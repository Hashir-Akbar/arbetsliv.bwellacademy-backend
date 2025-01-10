@extends('statement.base')

@section('page-title')
{{ __('statement.plan-title') }}
@stop

@section('tab-contents')

<section id="life-plan">
    <div>
        <p>Nu ska du tala om VARFÖR, NÄR och HUR du ska nå dina mål. Det kommer att bli din Livsstilsplan.</p>
        <?php $i = 0; ?>
        @foreach ($targets as $target)
        <div class="goal goal-container-{{ $i }}">
            <p>
                Mål <em>{{ $target['label'] }} {{ $target['value'] }} - {{ $target['vision'] }}</em> därför att<br>
                <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)" name="planDifference{{ $i }}" id="planDifference{{ $i }}" value="{{ isset($texts['planDifference' . $i]) ? $texts['planDifference' . $i] : '' }}" />
            </p>
            <p>
                Jag ska ha uppnått målet<br>
                <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)" name="planWhen{{ $i }}" id="planWhen{{ $i }}" value="{{ isset($texts['planWhen' . $i]) ? $texts['planWhen' . $i] : '' }}" />
            </p>
            <p>
                För att nå målet kommer jag att<br>
                <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)"  name="planDo{{ $i }}" id="planDo{{ $i }}" value="{{ isset($texts['planDo' . $i]) ? $texts['planDo' . $i] : '' }}" />
            </p>
            <p>
                Jag kommer att förbereda mig genom att<br>
                <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)" name="planHow{{ $i }}" id="planHow{{ $i }}" value="{{ isset($texts['planHow' . $i]) ? $texts['planHow' . $i] : '' }}" />
            </p>
            <p>
                Jag kommer att följa upp att jag är på rätt väg genom att<br>
                <input type="text" {{ !$editable ? 'disabled="disabled"' : '' }} maxlength="100" placeholder="(fyll i själv)" name="planFollowup{{ $i }}" id="planFollowup{{ $i }}" value="{{ isset($texts['planFollowup' . $i]) ? $texts['planFollowup' . $i] : '' }}" />
            </p>
        </div>
        <?php $i++; ?>
        @endforeach
    </div>

    @if ($editable)
    <div id="autosave-info">
        {{ __('profile.autosave-info') }}
    </div>
    @endif

    <div class="button-container">
        @if ($mock)
            <a href="{{ url('/statement/mock/plan/results') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @else
            <a href="#finish" class="finish-statement next-btn">{{ __('statement.btn-finish-plan') }}</a>
        @endif
    </div>
</section>

<div id="finish" class="modal-dialog zoom-anim-dialog mfp-hide">
    @if (App::isLocale('sv'))
    <h2>Avsluta livsstilsplanen</h2>
    <p>Om du väljer att avsluta livsstilsplanen kommer de här svaren att låsas, vilket betyder att du inte kan göra ändringar.</p>
    @else
    <h2>Finish lifestyle plan</h2>
    <p>If you choose to finish the lifestyle plan, these answers will be locked, which means you cannot make any changes.</p>
    @endif

    <form method="POST" action="{{ action('StatementController@postFinish', $profile->id) }}">
        @csrf
        <input type="hidden" name="user" value="{{ $profile->user->id }}">
        <input type="hidden" name="profile" value="{{ $profile->id }}">
        @if (App::isLocale('sv'))
        <input type="submit" class="save-statement next-btn" value="Avsluta livsstilsplanen">
        @else
        <input type="submit" class="save-statement next-btn" value="Finish lifestyle plan">
        @endif
    </form>
</div>

<script>
    window.profile_id = <?= $profile->id; ?>;
    window.editable = <?= $editable ? 'true' : 'false' ?>;
    window.mock = <?= $mock ? 'true' : 'false' ?>;

    $(document).ready(function() {

        $("#planWhen0").datepicker({dateFormat: "yy-mm-dd"});
        $("#planWhen1").datepicker({dateFormat: "yy-mm-dd"});
        $("#planWhen2").datepicker({dateFormat: "yy-mm-dd"});

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

        $('input[type="text"]').on('change', function (e) {
            var $this = $(this);
            var name = $this.attr('name');
            var content = $this.val();

            var data = {
                'type': 'plan',
                'name': name,
                'content': content
            };
            sendText(data, $this);
        });
    });

    function sendText(data, element)
    {
        var url = fms_url + '/statement/' + profile_id + '/text';

        $.ajax(url, {
            type: 'POST',
            data: data,
        });
    }

    function sendVisionValues(data, element)
    {
        var url = fms_url + '/statement/' + profile_id + '/vision';

        $.ajax(url, {
            type: 'POST',
            data: data,
        });
    }
</script>
@stop
