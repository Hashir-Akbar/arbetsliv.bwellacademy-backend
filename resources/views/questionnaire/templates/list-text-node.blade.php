<li class="text-node"{{ isset($form_name) ? ' data-question=' . $form_name : '' }}>
    <h3 class="title">{!! t($label) !!}</h3>
    <div class="row">
    @if ($has_help)
        <?php $thelp = t($help); ?>
        @if (!empty($thelp))
        <div class="help-button"></div>
        @else
        <div class="help-button-disabled"></div>
        @endif
    @endif
	    <p class="description">
	        {!! t($description) !!}
	    </p>
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