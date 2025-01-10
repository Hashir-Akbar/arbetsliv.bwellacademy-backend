<li class="question">
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    @if ($has_help)
        <?php $thelp = t($help); ?>
        @if (!empty($thelp))
        <div class="help-button"></div>
        @else
        <div class="help-button-disabled"></div>
        @endif
    @else
    <div class="help-button-padding"></div>
    @endif
    <div class="elements energy-question">
        @if (empty($values['weight']) || empty($values['length']) || empty($values['training']))
            Du måste svara på frågorna <em>Vikt</em>, <em>Längd</em> och <em>Fysisk träning</em>
        @else
            <div>Din vikt är {{ $values['weight'] ?? '0' }} kg</div>
            <div>Din längd är {{ $values['length'] ?? '0' }} cm</div>
            <div><strong>Ditt BMR</strong> är {{ $values['foodBMR'] ?? '0' }} kcal <a href="#food1-popup" class="open-popup-link">(Info 1)</a></div>
            <div><strong>Ditt PAL</strong> är {{ $values['foodPAL'] ?? '0' }} <a href="#food2-popup" class="open-popup-link">(Info 2)</a></div>
            <div><strong>Ditt energibehov</strong> är {{ $values['foodEnergyNeeds'] ?? '0' }} kcal en normal dag</div>
        @endif
    </div>
    @if ($has_help)
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
    @endif
</li>
