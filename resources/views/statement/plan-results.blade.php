@extends('statement.base')

@section('page-title')
{{ __('statement.plan-title') }}
@stop

@section('tab-contents')
<section id="plan-results">
    <div class="print-only">
        <div class="print-header">
            <img src="/images/logo-print.png">
        </div>
        @if ($mock)
            <h2>Livsstilsplan {{ __('profile.mock') }}</h2>
        @else
            <h2>Livsstilsplan {{ $user->full_name() }} {{ $profile->date }}</h2>
        @endif
    </div>

    <div id="plan-satisfied">
        @php
        $topSatisfieds = [];
        foreach ($satisfieds as $satisfied) {
            if ($satisfied['selected'] == 1) {
                $topSatisfieds[] = $satisfied;
            }
        }
        $text = '';
        $i = 1;
        foreach ($topSatisfieds as $satisfied) {
            $label = '<em>' . $satisfied['label'] . '</em>';
            if ($i == 1) {
                $text = $label;
            } else if ($i == count($topSatisfieds)) {
                $text .= ' och ' . $label;
            } else {
                $text .= ', ' . $label;
            }
            $i++;
        }
        @endphp
        <h3>
            @if (!empty($text))
            Jag är mest nöjd med {!! $text !!}.
            @endif
            @if (!empty($texts['satProfile']))
            Det gör att <em>{{ $texts['satProfile'] }}</em>.
            @endif
        </h3>
    </div>

    <div id="plan-goals">
        <?php $i = 0; ?>
        @foreach ($targets as $target)
        <div class="goal goal-container-{{ $i }}">
            <h3>
                Jag ska ha uppnått målet <em>{{ $target['label'] }} {{ $target['value'] }} - {{ $target['vision'] }},</em>
                @if (isset($texts['planWhen' . $i]))
                <em>{{ $texts['planWhen' . $i] }}</em>
                @endif
                @if (isset($texts['planDifference' . $i]))
                därför att <em>{{ $texts['planDifference' . $i] }}</em>.
                @endif
            </h3>
            @if (isset($texts['planDo' . $i]))
                <p>För att nå målet kommer jag att <em>{{ $texts['planDo' . $i] }}</em>.</p>
            @endif
            @if (isset($texts['planHow' . $i]))
                <p>Jag kommer att förbereda mig genom att <em>{{ $texts['planHow' . $i] }}</em>.</p>
            @endif
            @if (isset($texts['planFollowup' . $i]))
                <p>Jag kommer att följa upp att jag är på rätt väg genom att <em>{{ $texts['planFollowup' . $i] }}</em>.</p>
            @endif
        </div>
        <?php $i++; ?>
        @endforeach
    </div>

    <div id="good-luck">
        @if (App::isLocale('sv'))
        <h3>Lycka till!</h3>
        @else
        <h3>Good luck!</h3>
        @endif
    </div>

    <div class="button-container">
        <a href="#" class="next-btn" onclick="window.print();">
            @if (App::isLocale('sv'))
            Skriv ut
            @else
            Print
            @endif
        </a>
        @if ($isUsersProfile)
        <a href="/logout" class="prev-btn">
            @if (App::isLocale('sv'))
            Logga ut
            @else
            Log out
            @endif
        </a>
        @endif
    </div>
</section>

<script>
    $(window).bind("load", function() {
        setTimeout(function() {
            if (window.location.hash == "#print") {
                window.print();
                window.location.href = "/";
            }
        }, 1000);
    });
</script>
@stop
