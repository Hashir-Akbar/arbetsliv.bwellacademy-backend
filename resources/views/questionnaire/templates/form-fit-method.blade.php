<li class="question parent-question" data-category-id="4"{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }}>
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
        @if ($mock || !isset($profile))
        <input type="hidden" id="userAge" value="0">
        @else
        <input type="hidden" id="userAge" value="{{ \Carbon\Carbon::parse($profile->date)->diffInYears($user->birth_date) }}">
        @endif

        <input type="hidden" id="fitMethodValue" value="{{ isset($values['fitMethod']) ? intval($values['fitMethod']) : -1 }}">
        <input type="hidden" id="fitMethodDisabled" value="{{ $editable ? '0' : '1' }}">

        <div class="method-options">
            <h3>Maxtest</h3>

            <div class="method-option">
                @if (isset($values['fitMethod']) && $values['fitMethod'] == 7)
                <input type="radio" id="method-cooper" name="fitMethod" value="7" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-cooper" name="fitMethod" value="7" @disabled(!$editable)>
                @endif
                <label for="method-cooper">Coopertest</label>
            </div>

            <div class="method-option">
                @if (isset($values['fitMethod']) && $values['fitMethod'] == 6)
                <input type="radio" id="method-beep" name="fitMethod" value="6" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-beep" name="fitMethod" value="6" @disabled(!$editable)>
                @endif
                <label for="method-beep">Beeptest</label>
            </div>
        </div>

        <div class="method-options">
            <h3>Submaxtest</h3>

            <div class="method-option">
                @if (isset($values['fitMethod']) && $values['fitMethod'] == 0)
                <input type="radio" id="method-step" name="fitMethod" value="0" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-step" name="fitMethod" value="0" @disabled(!$editable)>
                @endif
                <label for="method-step">Steptest</label>
            </div>

            <div class="method-option">
                @if (isset($values['fitMethod']) && $values['fitMethod'] == 1)
                <input type="radio" id="method-bicycle" name="fitMethod" value="1" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-bicycle" name="fitMethod" value="1" @disabled(!$editable)>
                @endif
                @if (App::isLocale('en'))
                    <label for="method-bicycle">Bicycle ergometer</label>
                @else
                    <label for="method-bicycle">Ergometercykel</label>
                @endif
            </div>

            <div class="method-option">
                @if (isset($values['fitMethod']) && $values['fitMethod'] == 5)
                <input type="radio" id="method-walk" name="fitMethod" value="5" @disabled(!$editable) checked="checked">
                @else
                <input type="radio" id="method-walk" name="fitMethod" value="5" @disabled(!$editable)>
                @endif
                <label for="method-walk">1-Mile walk test (Nominellt 1609 m)</label>
            </div>
        </div>
        @include("questionnaire.templates._fit")
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
        var checked = $(this).find("input[name='fitMethod']:checked").first();
        var id = checked.attr("id");

        updateFitMethod(id);
    });

    $("input[name='fitMethod']").click(function(evt)
    {
        var target = evt.target;
        var id = target.getAttribute("id");

        updateFitMethod(id);
    });

    function updateFitMethod(id)
    {
        // console.log(id);

        var methods = [
            'step',
            'bicycle',
            'walk',
            'mlo2',
            'lo2',
            'beep',
            'cooper'
        ];

        for (var i = 0; i < methods.length; i++) {
            var e = $('#question-' + methods[i]);

            e.slideUp(100, function() {
                updateHeights();
            });
        }

        if (id) {
            setTimeout(function() {
                switch (id) {
                    case "method-step":
                        var e = $("#question-step");
                        break;
                    case "method-bicycle":
                        var e = $("#question-bicycle");
                        break;
                    case "method-walk":
                        var e = $("#question-walk");
                        break;
                    case "method-mlo2":
                        var e = $("#question-mlo2");
                        break;
                    case "method-lo2":
                        var e = $("#question-lo2");
                        break;
                    case "method-beep":
                        var e = $("#question-beep");
                        break;
                    case "method-cooper":
                        var e = $("#question-cooper");
                        break;
                    default:
                        break;
                }

                e.slideDown(100, function() {
                    updateHeights();
                });
            }, 100);
        }

        var disabled = $("#fitMethodDisabled").val();
        if (disabled === "1") {
            $("input[name='fitMethod']").each(function(idx, elem) {
                $(elem).prop("disabled", "disabled");
            });
        }
    }
</script>
