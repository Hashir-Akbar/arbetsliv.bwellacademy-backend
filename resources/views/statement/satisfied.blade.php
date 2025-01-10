@extends('statement.base')

@section('page-title')
{{ __('statement.satisfied-title') }}
@stop

@section('tab-contents')
<section>
    <div id="satisfied">
        @if (App::isLocale('sv'))
            <h2>Detta har du sagt att du är allra mest nöjd med</h2>
            <p>Klicka på de tre faktorer som du är allra mest nöjd med. Om du vill ändra ska du klicka på den du vill välja bort och sedan välja en ny.</p>
        @else
            <h2>This you have said that you are most satisfied with</h2>
            <p>Click on the three factors that you are most satisfied with. If you want to change, click the one you want to deselect and then select a new one.</p>
        @endif
        <ul>
            @foreach ($satisfieds as $satisfied)
            <li class="satisfied{{ $satisfied['selected'] == 1 ? ' selected' : ''}}" data-category-id="{{ $satisfied['category_id'] }}" data-profile-id="{{ $satisfied['profile_id'] }}"><div class="item">{{ $satisfied['label'] }}</div></li>
            @endforeach
        </ul>
    </div>

    <div id="topsatisfied-section" hidden>
        <h3>Beskriv hur detta bidrar till att du mår bra i livet i dag</h3>
        Jag är mest nöjd med <span id="topsatisfied"></span>. Det gör att<br>
        <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)" name="sat" id="sat" value="{{ $values['satProfile'] ?? '' }}" />
    </div>

    @if ($editable)
    <div id="autosave-info">
        {{ __('profile.autosave-info') }}
    </div>
    @endif

    <div class="button-container">
        @if ($mock)
            <a href="{{ url('/statement/mock/goals') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @else
            <a href="{{ url('/statement/' . $profile->id . '/goals') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @endif
    </div>
</section>

<script type="text/javascript">
    window.profile_id = <?= $profile->id; ?>;
    window.editable = <?= $editable ? 'true' : 'false' ?>;
    window.mock = <?= $mock ? 'true' : 'false' ?>;

    $(document).ready(function() {
        $('#satisfied li.satisfied').click(function() {
            if(window.editable) {
                var li = $(this);
                var n_selected = li.parent().find('.selected').length;
                var profile_id = li.data('profile-id');
                var category_id = li.data('category-id');
                if(li.hasClass('selected')) {
                    li.removeClass('selected');
                    sendSatisfiedValue(profile_id, category_id, 0);
                }
                else if(n_selected < 3) {
                    li.addClass('selected');
                    sendSatisfiedValue(profile_id, category_id, 1);
                }
                updateSatisfied();
            }
        });
        
        $('input[type="text"]').on('change', function(e) {
            var $this = $(this);
            var name = $this.attr('name');
            var re = /(.+)\[(.+)\]/g; 
            name = name.replace(re, "$1$2");

            var content = $this.val();
            var data = {
                'type': 'summary',
                'name': name,
                'content': content
            };
            sendText(data, $this);
        });

        updateSatisfied();
    });

    function sendSatisfiedValue(profile_id, category_id, value)
    {
        var url = fms_url + '/statement/' + profile_id + '/satisfied';

        var data = {
            'category_id': category_id,
            'value': value
        };

        $.ajax(url, {
            type: 'POST',
            data: data,
        });
    }

    function sendText(data, element)
    {
        var url = fms_url + '/statement/' + profile_id + '/text';

        $.ajax(url, {
            type: 'POST',
            data: data,
        });
    }

    function updateSatisfied()
    {
        var selected = $('#satisfied li.selected');
        var target_count = selected.length;
        var target_html = [];
        var i = 1;
        selected.each(function() {
            var li = $(this);
            var name = '<em>' + li.find('.item').html() + '</em>';
            if (i == 1) {
                target_html.push(`${ name }`);
            } else if (i == target_count) {
                target_html.push(` och ${ name }`);
            } else {
                target_html.push(`, ${ name }`);
            }
            i++;
        });
        if (target_count > 0) {
            $('#topsatisfied-section').show();
            $('#topsatisfied').html(target_html.join(''));
        } else {
            $('#topsatisfied-section').hide();
        }
    }
</script>
@stop
