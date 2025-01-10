@extends('statement.base')

@section('page-title')
{{ __('statement.goals-title') }}
@stop

@section('tab-contents')
<section>
    <div>
        @if (App::isLocale('sv'))
        <h2>Detta har du sagt att du vill förbättra</h2>
        <p>Välj nu högst tre förbättringar som är viktigast för dig. Dessa blir dina Livsstilsmål. Om du vill ändra ska du klicka på den du vill välja bort och sedan välja en ny.</p>
        @else
        <h2>You have said that you want to improve this</h2>
        <p>You can not make more than 3 changes at a time. Therefore, now choose the 3 most important improvements you want to make by clicking on the improvements that are most important to you. These will be your OBJECTIVES half a year ahead. If you want to change, click the one you want to deselect and then select a new one.</p>
        @endif
        <ul id="improves" style="color: #5b89a8;">
            @foreach ($improves as $improve)
            <li class="{{ $improve['selected'] ? 'selected' : '' }}" data-category-id="{{ $improve['category_id'] }}" data-value="{{ $improve['value'] }}"" data-vision="{{ $improve['vision'] }}"><div class="item">{{ $improve['label'] }}</div></li>
            @endforeach
        </ul>
    </div>

    <div id="topgoals-section" hidden>
        @if (App::isLocale('sv'))
        <h3>Mina viktigaste mål är alltså</h3>
        @else
        <h3>My most important goals are</h3>
        @endif
        <ol id="topgoals"></ol>
    </div>

    @if ($editable)
    <div id="autosave-info">
        {{ __('profile.autosave-info') }}
    </div>
    @endif

    <div class="button-container">
        @if ($mock)
            <a href="{{ url('/statement/mock/plan') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @else
            <a href="{{ url('/statement/' . $profile->id . '/plan') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @endif
    </div>

</section>

<div id="test-popup" class="white-popup mfp-hide">
    <p>Ditt värde i dag är <span id="current-value"></span>. Välj det värde du vill uppnå.</p>
    <p>
        <select class="vision-value" name="vision-value">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </p>
    <input type="hidden" name="vision-factor" value="">
    <input type="hidden" name="vision-factor-id" value="">
    <input type="hidden" name="vision-pieslice" value="">
    <a href="#" class="close-statement next-btn">Spara</a>
</div>

<script type="text/javascript">
    window.profile_id = <?= $profile->id; ?>;
    window.editable = <?= $editable ? 'true' : 'false' ?>;

    window.sendTargetValue = function(profile_id, category_id, value, callback)
    {
        var url = fms_url + '/statement/' + profile_id + '/target';
        console.log(url);

        $.ajax(url, {
            data: {
                category_id: category_id,
                value: value
            },
            type: 'POST',
            
            beforeSend: function(jqHXR, settings) {

            },
            success: function(d, status, jqHXR) {
                console.log(d);
                if(callback) {
                    callback();
                }
            }
        });
    };

    window.rebindUpdateTarget = function () {
        $('#improves li .item').unbind();
        bindUpdateTarget();
    };

    window.updateTargets = function () {
        var selected = $('#improves li.selected');
        var target_count = selected.length;
        var target_html = [];
        selected.each(function() {
            var li = $(this);
            var name = li.find('.item').html();
            var value = li.data('value');
            var vision = li.data('vision');
            target_html.push(`<li><em>${ name }</em> från ${ value } till ${ vision }</li>`);
        });
        if (target_count > 0) {
            $('#topgoals-section').show();
            $('#topgoals').html(target_html.join(''));
        } else {
            $('#topgoals-section').hide();
        }
    };

    function bindUpdateTarget() {
        $('#improves li .item').click(function() {
            if(window.editable) {
                var li = $(this).parent();
                var n_selected = li.parent().find('.selected').length;
                var category_id = li.data('category-id');
                var curVal = li.data('value');
                var vision = li.data('vision');
                var name = li.html();
                if(li.hasClass('selected')) {
                    li.removeClass('selected');
                    sendTargetValue(profile_id, category_id, 0, function() {
                    });
                    updateTargets();
                    return;
                }

                if(n_selected < 3) {
                    $.magnificPopup.open({
                    items: 
                        {
                            src: $('#test-popup')
                        },
                        type: 'inline'
                    });

                    var default_vision = curVal;
                    if(vision) {
                        default_vision = vision;
                    }
                    $('#current-value').html(curVal);
                    $('.vision-value').val(default_vision);
                    $('input[name=vision-factor]').val(name);
                    $('input[name=vision-factor-id]').val(category_id);
                }
            }
        });
    }

    $(document).ready(function() {
        bindUpdateTarget();
        updateTargets();

        $('.finish-statement').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: false,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

        $('.close-finish').click(function(e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    });

    function sendVisionValues(data, element)
    {
        var url = fms_url + '/statement/' + profile_id + '/vision';

        $.ajax(url, {
            type: 'POST',
            data: data,
        });
    }

    $(".close-statement").click(function(e){
        e.preventDefault();

        var name = $("input[name=vision-factor]").val();
        var id = $("input[name=vision-factor-id]").val();
        var elem = $("select[name=vision-value]").val();

        var data = {
            category_id: id,
            name: name,
            value: elem
        }

        sendVisionValues(data, elem);

        sendTargetValue(profile_id, id, 1, function() {
        });

        var li = $('#improves li[data-category-id="' + id + '"]');
        li.addClass('selected');
        li.data('vision', elem);

        $.magnificPopup.close()

        window.updateTargets();

    });
</script>
@stop
