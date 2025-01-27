@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Nya anställda till avdelning {{ $section->full_name() }}
@else
    Nya elever till klass {{ $section->full_name() }}
@endif
@stop

@section('content')
<style>
    .info-form, .secret-code-container {
    display: block;
    width: 100%; /* Optional: Ensures they take up the full width */
    clear: both; /* Clears any floating elements */
}
</style>
    <div style="margin-bottom: 100px;">
    {{ Form::open(array('action' => array("StudentController@postNewMultiple", $section->id), 'class' => 'info-form new-multiple-students-form')) }}

    <div>
        <input type="checkbox" name="is_test" {{ Request::old('is_test') ? 'checked="checked"' : '' }}>
        <label for="is_test">Testanvändare</label>
    </div>

    <div class="responsive-table">
        <table class="new-students-form">
            <thead>
                <tr>
                    <th>Förnamn *</th>
                    <th>Efternamn *</th>
                    <th>Emailadress</th>
                    <th>Födelsedatum *</th>
                    <th>Kön</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (Session::has('old_data'))
                    <?php $i = 0; ?>
                    @foreach (Session::get('old_data') as $user)
                    @if (strlen($user['error']) > 0)
                    <tr>
                        <td colspan="7" class="errors">{!! $user['error'] !!}</td>
                    </tr>
                    @endif
                    <tr>
                         <td class="first_name">
                            <input type="text" name="users[{{ $i }}][first_name]" value="{{ $user['first_name'] }}" required>
                        </td>
                        <td class="last_name">
                            <input type="text" name="users[{{ $i }}][last_name]" value="{{ $user['last_name'] }}" required>
                        </td>
                        <td class="email">
                            <input type="email" name="users[{{ $i }}][email]" value="{{ $user['email'] }}">
                        </td>
                        <td class="birth_date">
                            <input type="text" class="birth_date" name="users[{{ $i }}][birth_date]" size="10" value="{{ $user['birth_date'] }}" placeholder="åååå-mm-dd"> 
                        </td>
                        <td class="sex">
                            <select name="users[{{ $i }}][sex]">
                                @if (!isset($user['sex']))
                                <option value="U" selected="selected">Okänt</option>
                                @else
                                <option value="U">Okänt</option>
                                @endif
                                @if ($user['sex'] == "M")
                                <option value="M" selected="selected">{{ t("general.male") }}</option>
                                @else
                                <option value="M">{{ t("general.male") }}</option>
                                @endif
                                @if ($user['sex'] == "F")
                                <option value="F" selected="selected">{{ t("general.female") }}</option>
                                @else
                                <option value="F">{{ t("general.female") }}</option>
                                @endif
                            </select>
                        </td>
                        <td class="row-actions">
                            <a class="delete-row" href="#">X</a>
                        </td>
                    </tr>
                    <?php $i += 1; ?>
                    @endforeach
                @else
                <tr>
                     <td class="first_name">
                        <input type="text" name="users[0][first_name]" required>
                    </td>
                    <td class="last_name">
                        <input type="text" name="users[0][last_name]" required>
                    </td>
                    <td class="email">
                        <input type="email" name="users[0][email]">
                    </td>
                    <td class="birth_date">
                        <input type="text" class="birth_date" name="users[0][birth_date]" size="10" placeholder="åååå-mm-dd"> 
                    </td>
                    <td class="sex">
                        <select name="users[0][sex]">
                            <option value="U">{{ t("general.unknown") }}</option>
                            <option value="M">{{ t("general.male") }}</option>
                            <option value="F">{{ t("general.female") }}</option>
                        </select>
                    </td>
                    <td class="row-actions">
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <input type="button" id="add-row" class="btn add-row-button" value="Ny rad">

    {{ Form::submit('Spara', array('class' => 'btn')) }}
    <a class="back-link" href="{{ url('/students?section=' . $section->id) }}">Avbryt</a>

    {{ Form::close() }}
    </div>
    <script>
        $("#add-row").click(function()
        {
            var tableBody = $(".new-students-form tbody");
            var idx = tableBody.find("tr").size();
            var row = tableBody.find("tr:last").clone();
            var inputs = row.find("td").find("input");

            $(inputs).each(function(_, element)
            {
                var e = $(element);

                var oldName = e.attr('name');
                var newName = oldName.replace(/\[(\d+?)\]/, "[" + idx + "]");
                e.attr('name', newName);

                e.val("");
            });

            $("select", row).each(function(_, elem) {
                var select = $(elem);
                var oldSelectName = select.attr('name');
                var newSelectName = oldSelectName.replace(/\[(\d+?)\]/, "[" + idx + "]");
                select.attr('name', newSelectName);
            });

            var rem = $(row.find('.row-actions'));
            if (rem.children().length == 0)
            {
                var removeLink = $(document.createElement("a"));
                removeLink.addClass("delete-row");
                removeLink.attr('href', "#");
                removeLink.html("X");
                removeLink.appendTo(rem);
            }

            rem.appendTo(row);

            row.appendTo(tableBody);
        });

        $("table").delegate('.delete-row', 'click', function() {
            var row = $(this).parent().parent();
            row.remove();
            return false;
        });
    </script>
@stop