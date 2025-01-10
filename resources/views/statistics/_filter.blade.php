<div class="sidepanel side-filter">
<h2>{{ __('statistics.filter-title') }}</h2>
<nav class="tab-container">
    <ul class="tabs">
        <li><a id="options-link" data-tab="options" href="#options">{{ __('statistics.tab-filter') }}</a></li>
        <li><a id="compare-link" data-tab="compare" href="#compare">{{ __('statistics.tab-compare') }}</a></li>
    </ul>

    <!-- Filterinställningar -->
    <section id="options-contents" class="tab-contents">
        <div style="margin-bottom: 10px;">
            <h5 class="title" style="color: #f34f98;">{{ __('statistics.filter-type') }}</h5>
            <input type="radio" name="filter-type" id="filter-type-school" value="skolan" checked="checked"><label for="filter-type-school" style="padding-left: 5px; color: #f34f98;">{{ __('statistics.filter-type-school') }}</label><br>
            <input type="radio" name="filter-type" id="filter-type-global" value="globalt"><label for="filter-type-global" style="padding-left: 5px; color: #f34f98;">{{ __('statistics.filter-type-global') }}</label>
        </div>
        <div class="filter-option" id="country-option" data-in-use="yes" style="display: none;">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.country') }}</a></h5>
            <div class="elements">
                <select name="country" id="country" class="filter-select">
                    <option value="0">{{ __('statistics.all') }}</option>
                    @foreach ($countries as $label => $id)
                        <option value="{{ $id }}">{{ t($label) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="filter-option" id="county-option" data-in-use="yes" style="display: none;">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.county') }}</a></h5>
            <div class="elements">
                <select name="county" id="county" class="filter-select">
                    <option value="0">{{ __('statistics.all') }}</option>
                    @foreach ($counties as $country => $conts)
                    <optgroup label="{{ t($country) }}">
                        @foreach ($conts as $countyId => $countyLabel)
                        <option value="{{ $countyId }}">{{ $countyLabel }}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        @if (config('fms.type') == 'work')
            <div class="filter-option" id="business-category-option" data-in-use="yes" style="display: none;">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.business-category') }}</a></h5>
                <div class="elements">
                    <select name="business-category" id="business-category" class="filter-select">
                        <option value="0">{{ __('statistics.all') }}</option>
                        @foreach($businessCategories as $businessCategory)
                            <option value="{{ $businessCategory->id }}">{{ $businessCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        @if (config('fms.type') == 'school')
            <div class="filter-option" id="school-type-option" data-in-use="yes" style="display: none;">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.school-type') }}</a></h5>
                <div class="elements">
                    <select name="school-type" id="school-type" class="filter-select">
                        <option value="0">{{ __('statistics.all') }}</option>
                        <option value="1">{{ __('statistics.compulsory-school') }}</option>
                        <option value="2">{{ __('statistics.secondary-school') }}</option>
                    </select>
                </div>
            </div>
            <div class="filter-option" id="programme-option">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.programme') }}</a></h5>
                <div class="elements">
                    <select name="programme" id="programme-school" class="filter-select programme-option" data-in-use="true">
                        <option value="0">{{ __('statistics.all') }}</option>
                        @foreach ($programmes as $programme)
                            <option value="{{ $programme->id }}">{{ $programme->label }}</option>
                        @endforeach
                    </select>
                    <select name="programme" id="programme-all" class="filter-select programme-option hidden" data-in-use="false">
                        <option value="0">{{ __('statistics.all') }}</option>
                        @foreach ($allProgrammes as $programme)
                            <option value="{{ $programme->id }}">{{ $programme->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="filter-option" id="class-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.class') }}</a></h5>
            <div class="elements">
                <select name="section[]" id="section" class="filter-select" multiple="multiple">
                    <option value="0">{{ __('statistics.all') }}</option>
                    @if ($user->isSuperAdmin())
                        @foreach ($sections as $unit => $sectionsArray)
                            <optgroup label="{{ $unit }}">
                                @foreach ($sectionsArray as $section)
                                    <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    @else
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ __('statistics.class') }} {{ $section->full_name() }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        @if (count($sampleGroups) > 0)
        <div class="filter-option" id="sample-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.sample-groups') }}</a></h5>
            <div class="elements">
                <select name="sample-group" id="sample-group" class="filter-select">
                    <option value="0">{{ __('statistics.all') }}</option>
                    @foreach ($sampleGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <div class="filter-option" id="sex-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.sex') }}</a></h5>
            <div class="elements">
                <select class="filter-select" name="sex" id="sex">
                    <option value="0">{{ __('statistics.all') }}</option>
                    <option value="1">{{ __('statistics.male') }}</option>
                    <option value="2">{{ __('statistics.female') }}</option>
                </select>
            </div>
        </div>
        <div class="filter-option" id="age-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.age') }}</a></h5>
            <div class="elements">
                <input type="number" name="age-from" id="age-from" class="filter-text" placeholder="{{ __('statistics.from') }}">
                <input type="number" name="age-to" id="age-to" class="filter-text" placeholder="{{ __('statistics.to') }}">
            </div>
        </div>
        @if (config('fms.type') == 'school')
            <div class="filter-option" id="grade-option">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.grade') }}</a></h5>
                <div class="elements">
                    <select name="grade" id="grade" class="filter-select">
                        <option value="0">{{ __('statistics.all') }}</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="5">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="11">{{ __('statistics.ss') }}1</option>
                        <option value="12">{{ __('statistics.ss') }}2</option>
                        <option value="13">{{ __('statistics.ss') }}3</option>
                        <option value="14">{{ __('statistics.ss') }}4</option>
                        <option value="15">{{ __('statistics.ss') }}5</option>
                        <option value="16">{{ __('statistics.ss') }}6</option>
                    </select>
                </div>
            </div>
            <div class="filter-option hidden" id="grade-secondary-option">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.grade') }}</a></h5>
                <div class="elements">
                    <select name="grade" id="grade" class="filter-select">
                        <option value="0">{{ __('statistics.all') }}</option>

                    </select>
                </div>
            </div>
            <div class="filter-option" id="term-option">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.school-year') }}</a></h5>
                <div class="elements">
                    <div class="term-from">
                        <span>{{ __('statistics.from') }}</span><br>
                        <select name="year-from" id="year-from" class="filter-select">
                            <option value="0">{{ __('statistics.all') }}</option>
                            @for ($i = date("Y"); $i >= 1985; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <select name="semester-from" id="semester-from" class="filter-select">
                            <option value="0">{{ __('statistics.all') }}</option>
                            <option value="1">{{ __('statistics.semester-spring') }}</option>
                            <option value="2">{{ __('statistics.semester-autumn') }}</option>
                        </select>
                    </div>
                    <div class="term-to">
                        <span>{{ __('statistics.to') }}</span><br>
                        <select name="year-to" id="year-to" class="filter-select">
                            <option value="0">{{ __('statistics.all') }}</option>
                            @for ($i = date("Y"); $i >= 1985; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <select name="semester-to" id="semester-to" class="filter-select">
                            <option value="0">{{ __('statistics.all') }}</option>
                            <option value="1">{{ __('statistics.semester-spring') }}</option>
                            <option value="2">{{ __('statistics.semester-autumn') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        @else
            <div class="filter-option" id="date-option">
                <h5 class="title"><a href="javascript:;">{{ __('statistics.date') }}</a></h5>
                <div class="elements">
                    <div class="term-from">
                        <span>{{ __('statistics.from') }}</span><br>
                        <input type="date" name="date-from" id="date-from" class="filter-text">
                    </div>
                    <div class="term-to">
                        <span>{{ __('statistics.to') }}</span><br>
                        <input type="date" name="date-to" id="date-to" class="filter-text">
                    </div>
                </div>
            </div>
        @endif
        <div class="filter-option" id="profile-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.profile') }}</a></h5>
            <div class="elements">
                <select class="filter-select" name="profile-nb" id="profile-nb">
                    <option value="5">{{ __('statistics.profile-last') }}</option>
                    <option value="0">{{ __('statistics.profile-first') }}</option>
                    <option value="1">{{ __('statistics.profile-second') }}</option>
                    <option value="2">{{ __('statistics.profile-third') }}</option>
                </select>
            </div>
        </div>
        <div class="filter-option filter-risk-groups" id="risk-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.risk-group') }}</a></h5>
            <div class="elements">
                <input type="checkbox" name="risk-groups.healthy" id="risk-groups-healthy"> <label for="risk-groups-healthy">{{ __('statistics.risk-group-healthy') }}</label><br>
                <input type="checkbox" name="risk-groups.warning" id="risk-groups-warning"> <label for="risk-groups-warning">{{ __('statistics.risk-group-warning') }}</label><br>
                <input type="checkbox" name="risk-groups.risk" id="risk-groups-risk"> <label for="risk-groups-risk">{{ __('statistics.risk-group-risk') }}</label>
            </div>
        </div>
        <div class="filter-option filter-categories" id="bars-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.bars') }}</a></h5>
            <div class="elements">
                <a class="btn open-choose-categories" href="#choose-categories">{{ __('statistics.select') }}</a>
                <ul id="categories" class="categories"></ul>
            </div>
        </div>
        <div class="filter-option filter-cross-reference" id="cross-reference-option">
            <h5 class="title"><a href="javascript:;">{{ __('statistics.factors') }}</a></h5>
            <div class="elements">
                <a class="btn new-cross-reference" href="#new-cross-reference">{{ __('statistics.select') }}</a>
                <ul id="constraints" class="constraints"></ul>
            </div>
        </div>

        <div class="filter-actions" style="margin-bottom: 20px;">
            <a href="#search-filter" class="btn search-filter">{{ __('statistics.search') }}</a>
            <a href="#save-filter" class="btn open-save-filter">{{ __('statistics.save') }}</a>
            <a href="#reset-filters" class="btn reset-filters">{{ __('statistics.reset') }}</a>
            <!-- <a href="#export-filter" class="btn export-filter">Exportera</a> -->
        </div>

        <h4>{{ __('statistics.saved-selections') }}</h4>
        <ul class="quick-list user-list">
            @foreach ($userFilters as $filter)
                <li data-slug="{{ $filter['slug'] }}"
                    data-filter='{{ $filter["filter"] }}'>
                    <a href="javascript:;" class="set-filter">{{ $filter["name"] }}</a>
                    <a href="#remove-filter" class="remove-filter-link remove-button">X</a>
                </li>
            @endforeach
        </ul>
    </section>

    <!-- Jämförelse -->
    <section id="compare-contents" class="tab-contents">
        <input type="hidden" id="compare-type" value="">
        <div class="compare-options">
            <h4>{{ __('statistics.compare-options') }}</h4>
            <a href="javascript:;" data-target="sections">{{ __('statistics.compare-sections') }}</a><br>
            @if (config('fms.type') == 'school')
                <a href="javascript:;" data-target="programmes">{{ __('statistics.compare-programmes') }}</a><br>
            @endif
            @if (count($sampleGroups) > 0)
                <a href="javascript:;" data-target="groups">{{ __('statistics.compare-groups') }}</a><br>
            @endif
            <a href="javascript:;" data-target="user-filters">{{ __('statistics.compare-user-filters') }}</a>
        </div>
        <div id="compare-sections-container" class="compare-option">
            <h4>{{ __('statistics.compare-sections') }}</h4>
            <select name="compare[sections]" id="compare-sections" multiple="multiple">
            @foreach ($filters as $filter)
                <option value="{{ $filter['id'] }}">
                    @if ($filter['type'] == "section")
                    {{ __('statistics.class') }}
                    @endif
                    {{ $filter['name'] }}
                </option>
            @endforeach
            </select>
        </div>
        @if (config('fms.type') == 'school')
            <div id="compare-programmes-container" class="compare-option">
                <h4>Program</h4>
                <select name="compare[programmes]" id="compare-programmes" multiple="multiple">
                @foreach ($programmes as $program)
                    <option value="{{ $program->id }}">{{ $program->label }}</option>
                @endforeach
                </select>
            </div>
        @endif
        @if (count($sampleGroups) > 0)
        <div id="compare-groups-container" class="compare-option">
            <h4><a href="/admin/samples">{{ __('statistics.compare-groups') }}</a></h4>
            <select name="compare[groups]" id="compare-groups" multiple="multiple">
            @foreach ($sampleGroups as $group)
                <option value="{{ $group->id }}">{{ $group->label }}</option>
            @endforeach
            </select>
        </div>
        @endif
        <div id="compare-user-filters-container" class="compare-option">
            <h4>Egna urval</h4>
            <select name="compare[user-filters]" id="compare-user-filters" multiple="multiple">
                @foreach ($userFilters as $filter)
                    <option value="{{ $filter['slug'] }}" data-filter='{{ $filter["filter"] }}'>{{ $filter["name"] }}</option>
                @endforeach
            </select>
        </div>
        <div class="compare-actions">
            <h4>{{ __('statistics.compare-view-mode') }}</h4>
            <input type="radio" name="comparesite" value="multiple" checked="checked" />{{ __('statistics.compare-alt-1') }}<br />
            <input type="radio" name="comparesite" value="single" />{{ __('statistics.compare-alt-2') }}<br />

            <h4>Visningsalternativ</h4>
            <div class="compare-option compare-categories">
                <h5 class="title"><a href="javascript:;">Kategorier</a></h5>
                <div class="elements">
                    <a class="btn open-choose-categories" href="#choose-compare-categories">Ändra</a>
                    <ul id="categories" class="categories"></ul>
                </div>

            </div>

            <a href="javascript:;" class="btn start-compare">{{ __('statistics.compare-compare') }}</a>
            <a href="javascript:;" class="btn choose-new-option">{{ __('statistics.compare-change-option') }}</a>
        </div>
    </section>
</nav>
</div>

{{-- Dialoger --}}

<div id="choose-categories" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>{{ __('statistics.bars') }}</h2>
    <p>
        {{ __('statistics.bars-info') }}
    </p>
    <div class="filter-cats">
    @foreach ($categories as $category)
        @if (isset($defaultCategories[$category->name]))
        <input type="checkbox" data-label="{{ t($category->label) }}" name="category[{{ $category->name }}]" id="cat-{{ $category->name }}" data-default="yes" checked="checked"> <label for="{{ $category->name }}">{{ t($category->label) }}</label><br>
        @else
        <input type="checkbox" data-label="{{ t($category->label) }}" name="category[{{ $category->name }}]" id="cat-{{ $category->name }}" data-default="no"> <label for="{{ $category->name }}">{{ t($category->label) }}</label><br>
        @endif
    @endforeach
    </div>
    <br>
    <button class="save-categories btn">{{ __('statistics.save') }}</button> <!-- TODO: återställ knapp -->
</div>

<div id="choose-compare-categories" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>{{ __('statistics.bars') }}</h2>
    <p>
        {{ __('statistics.bars-info') }}
    </p>
    <div class="filter-cats">
    @foreach ($categories as $category)
        @if (isset($defaultCategories[$category->name]))
        <input type="checkbox" data-label="{{ t($category->label) }}" name="category[{{ $category->name }}]" id="cat-{{ $category->name }}" data-default="yes" checked="checked"> <label for="{{ $category->name }}">{{ t($category->label) }}</label><br>
        @else
        <input type="checkbox" data-label="{{ t($category->label) }}" name="category[{{ $category->name }}]" id="cat-{{ $category->name }}" data-default="no"> <label for="{{ $category->name }}">{{ t($category->label) }}</label><br>
        @endif
    @endforeach
    </div>
    <br>
    <button class="save-categories btn">{{ __('statistics.save') }}</button>
</div>

<div id="new-cross-reference" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>Ny begränsning</h2>
    <p>
        Kryssa i de faktorer du vill korskoppla och vilket värde.
    </p>
    {{--<p>
        1 och 2 betyder Risk. 3, 4 och 5 betyder Frisk.
    </p>--}}
    <div class="filter-cr">
        <input type="hidden" name="saving" id="saving" value="0">
        <div class="cr-field">
            <label for="cr-categories">Faktor</label><br>
            <select name="cr-categories" id="cr-categories">
                <optgroup label="Faktorer">
                    @foreach ($categories as $category)
                    <option value="{{ $category->name }}" id="cr-{{ $category->name }}">{{ t($category->label) }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="cr-checkboxes">
            <div class="error"></div>
            <input type="checkbox" name="cr-1" id="cr-1"> <label for="cr-1">1</label>
            <input type="checkbox" name="cr-2" id="cr-2"> <label for="cr-2">2</label>
            <input type="checkbox" name="cr-3" id="cr-3"> <label for="cr-3">3</label>
            <input type="checkbox" name="cr-4" id="cr-4"> <label for="cr-4">4</label>
            <input type="checkbox" name="cr-5" id="cr-5"> <label for="cr-5">5</label><br>
            <input type="checkbox" name="cr-risk" id="cr-risk"> <label for="cr-risk" class="cr-risk">Risk</label>
            <input type="checkbox" name="cr-healthy" id="cr-healthy"> <label for="cr-healthy" class="cr-healthy">Frisk</label>
            <input type="checkbox" name="cr-unknown" id="cr-unknown"> <label for="cr-unknown" class="cr-unknown">Okänd</label>
        </div>
    </div>
    <button class="add-cross-reference btn">Välj faktor</button>
</div>

<div id="remove-cr" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>Ta bort begränsning</h2>
    <p>
        Är du säker på att du vill ta bort <span class="factor-name"></span> som begränsning?
    </p>
    <button type="button" class="remove-cr-btn btn">Ta bort</button>
</div>

<div id="save-filter" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>
        @if (App::isLocale('sv'))
        Spara urval
        @else
        Save selection
        @endif
    </h2>
    <p>
        @if (App::isLocale('sv'))
        Ge ett namn för det här urvalet!
        @else
        Give the selection a name!
        @endif
    </p>
    <div class="filter-save">
        <label for="filter-name">
            @if (App::isLocale('sv'))
            Namn
            @else
            Name
            @endif
        </label><br>
        <input type="text" name="filter-name" id="filter-name"><br>
        <!-- <label for="filter-slug">Kort namn</label><br> -->
        <input type="hidden" name="filter-slug" id="filter-slug"><br>
    </div>
    <br>
    <button class="save-filter btn">{{ __('statistics.save') }}</button>
</div>

<div id="remove-filter" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>
        @if (App::isLocale('sv'))
        Ta bort sparat urval
        @else
        Remove selection
        @endif
    </h2>
    <p>
        @if (App::isLocale('sv'))
        Är du säker på att du vill ta bort urvalet <span class="user-filter-name"></span>?
        @else
        Are you sure you want to remove the selection <span class="user-filter-name"></span>?
        @endif
    </p>
    <button type="button" class="remove-filter-btn btn">{{ __('statistics.remove') }}</button>
</div>

{{-- / Dialoger --}}

<script src="{{ asset('/vendor/sumoselect-3.0.2/jquery.sumoselect.min.js') }}"></script>
<script src="{{ asset(version('/js/filtering.js')) }}"></script>
<script>
    @if (count($userFilters) > 0)
    window.userFilters = [];
    @else
    window.userFilters = [];
    @endif

    $(window).ready(function() {
        $("#section").SumoSelect({
            placeholder: "Välj",
            captionFormat: "{0} valda",
            captionFormatAllSelected: "Alla valda",
        });
    });
</script>

<style>
    .optWrapper.multiple {
        width: 400px;
        right: 0;
        left: auto;
    }
    .optWrapper.multiple .options {
        max-height: 500px;
    }
</style>
