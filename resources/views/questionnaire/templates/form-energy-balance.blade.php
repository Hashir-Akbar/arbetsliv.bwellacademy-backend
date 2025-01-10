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
            <div>Ditt energibehov är {{ $values['foodEnergyNeeds'] ?? '0' }} kcal</div>
            <div>Ditt energiintag är <span class="energy-intake-value">{{ $values['foodEnergyIntake'] ?? '0' }}</span> kcal</div>
            <div>Resultat <span class="energy-balance-value">{{ ($values['foodEnergyBalance'] ?? 0) >= 0 ? '+' : '' }}{{ $values['foodEnergyBalance'] ?? '0' }}</span> kcal</div>
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
