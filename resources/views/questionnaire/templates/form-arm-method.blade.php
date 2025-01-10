<li class="question parent-question" data-category-id="62"{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }}>
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    @if (isset($has_help) && $has_help)
        <?php $thelp = t($help); ?>
        @if (!empty($thelp))
        <div class="help-button"></div>
        @else
        <div class="help-button-disabled"></div>
        @endif
    @else
    <div class="help-button-padding"></div>
    @endif
    <div class="elements">
        <input type="hidden" id="armMethodValue" value="{{ isset($values['armMethod']) ? intval($values['armMethod']) : -1 }}">
        <input type="hidden" id="armMethodDisabled" value="{{ $editable ? '0' : '1' }}">

        <div class="method-options">
            <div class="method-option">
                @if (isset($values['armMethod']) && $values['armMethod'] == 1)
                <input type="radio" id="method-weights" name="armMethod" value="1" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-weights" name="armMethod" value="1" @disabled(!$editable)>
                @endif
                @if (App::isLocale('en'))
                    <label for="method-weights">Weights</label>
                @else
                    <label for="method-weights">Vikter</label>
                @endif
            </div>

            <div class="method-option">
                @if (isset($values['armMethod']) && $values['armMethod'] == 2)
                <input type="radio" id="method-pushups" name="armMethod" value="2" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-pushups" name="armMethod" value="2" @disabled(!$editable)>
                @endif
                @if (App::isLocale('en'))
                    <label for="method-pushups">Pushups</label>
                @else
                    <label for="method-pushups">Armböjningar</label>
                @endif
            </div>
        </div>
    </div>
    @if (isset($has_help) && $has_help)
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
    @endif
</li>
<script>
    $(document).ready(function()
    {
        var checked = $(this).find("input[name='armMethod']:checked").first();
        var id = checked.attr("id");

        updateArmMethod(id);
    });

    $("input[name='armMethod']").click(function(evt)
    {
        var target = evt.target;
        var id = target.getAttribute("id");

        updateArmMethod(id);
    });

    function updateArmMethod(id)
    {
        // console.log(id);

        $("input[name='armMethod']").each(function(idx, elem) {
            var tid = elem.getAttribute("id");

            switch (tid) {
                case "method-weights":
                    var e = $('li[data-question="strArm"]');
                    break;
                case "method-pushups":
                    var e = $('li[data-question="pushups"]');
                    break;
                default:
                    break;
            }

            e.slideUp(100, function() {
                updateHeights();
            });
        });

        if (id) {
            setTimeout(function() {
                switch (id) {
                    case "method-weights":
                    var e = $('li[data-question="strArm"]');
                        break;
                    case "method-pushups":
                    var e = $('li[data-question="pushups"]');
                        break;
                    default:
                        break;
                }

                e.slideDown(100, function() {
                    updateHeights();
                });
            }, 100);
        }

        var disabled = $("#armMethodDisabled").val();
        if (disabled === "1") {
            $("input[name='armMethod']").each(function(idx, elem) {
                $(elem).prop("disabled", "disabled");
            });
        }
    }
</script>
