<?php

use App\ProfileFactor;
use App\QuestionnaireQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('questionnaire_questions', function (Blueprint $table) {
        //     //
        // });

        $sleepHour = QuestionnaireQuestion::find(86);
        $sleepHour->data = '{"items":["5","4","3","2","1"],"labels":["Mer \u00e4n 9 timmar","9 timmar","8 timmar","7 timmar","Mindre \u00e4n 6 timmar"],"count":5,"toggle_value":"1"}';
        $sleepHour->save();

        $alcoholOften = QuestionnaireQuestion::find(113);
        $alcoholOften->has_subquestion = 0;
        $alcoholOften->is_conditional = 0;
        $alcoholOften->save();

        // $alcoholEffect = QuestionnaireQuestion::find(112);
        // $alcoholEffect->delete();
        QuestionnaireQuestion::destroy(112);

        $drugsFriends = QuestionnaireQuestion::find(182);
        $drugsFriends->category_id = null;
        $drugsFriends->save();

        // $dopning = QuestionnaireGroup::find(21);

        $activities = QuestionnaireQuestion::find(83);
        $activities->data = '{"items":["5","4","3","2","1"],"labels":["Ja, mycket bra","Ja, bra","Ja, ganska bra","Nej, f\u00f6r kr\u00e4vande","Nej, f\u00f6r f\u00e5"],"count":5}';
        $activities->save();

        $media = QuestionnaireQuestion::find(190);
        $media->data = '{"items":["5","4","3","2","1"],"labels":["under 30 minuter","\u00bd-1 timma","1-2 timmar","2-4 timmar","\u00d6ver 4 timmar"],"count":5}';
        $media->save();

        $friends = QuestionnaireQuestion::find(84);
        $friends->data = '{"items":["5","4","3","2","1"],"labels":["Ja, mycket bra","Ja, bra","Ja, r\u00e4tt s\u00e5 bra","Nej, ganska d\u00e5liga","Nej, inte alls"],"count":5}';
        $friends->save();

        $adults = QuestionnaireQuestion::find(90);
        $adults->data = '{"items":["1","2","3","4","5"],"labels":["Nej, inte alls","Nej, ganska d\u00e5liga","Ja, ganska bra","Ja, bra","Ja, mycket bra"],"count":5}';
        $adults->save();

        $schlGoal = QuestionnaireQuestion::find(97);
        $schlGoal->data = '{"items":["5","4","3","2","1"],"labels":["Mycket h\u00f6ga","H\u00f6ga","Ganska h\u00f6ga","L\u00e5ga","Mycket l\u00e5ga"],"count":5,"toggle_value":"1"}';
        $schlGoal->save();

        $schlResult = QuestionnaireQuestion::find(98);
        $schlResult->data = '{"items":["5","4","3","2","1"],"labels":["Helt och hållet","Nästan helt","Tveksamt","Troligen inte","Inte alls"],"count":5,"toggle_value":"1"}';
        $schlResult->save();

        $schlComfort = QuestionnaireQuestion::find(99);
        $schlComfort->has_subquestion = 0;
        $schlComfort->data = '{"items":["5","4","3","2","1"],"labels":["Ja, mycket bra","Ja, bra","Ja, ganska bra","Nej, ganska d\u00e5ligt","Nej, inte alls"],"count":5,"toggle_value":"1"}';
        $schlComfort->save();

        $schlSeen = QuestionnaireQuestion::find(100);
        $schlSeen->data = '{"items":["5","4","3","2","1"],"labels":["Mycket bra","Bra","Ganska bra","Ganska d\u00e5ligt","Inte alls"],"count":5,"toggle_value":"1"}';
        $schlSeen->save();

        $schlInfl = QuestionnaireQuestion::find(101);
        $schlInfl->data = '{"items":["5","4","3","2","1"],"labels":["Mycket bra","Bra","Ganska bra","Ganska d\u00e5ligt","Inte alls"],"count":5,"toggle_value":"1"}';
        $schlInfl->save();

        // $schlCalmness = QuestionnaireQuestion::find(103);
        // $schlCalmness->data = '{"items":["5","4","3","2","1"],"labels":["Ja, n\u00e4stan alltid","Ja, oftast","Ja, ganska ofta","Nej, s\u00e4llan","Nej, n\u00e4stan aldrig"],"count":5,"toggle_value":"1"}';
        // $schlCalmness->save();

        $schlSafety = QuestionnaireQuestion::find(195);
        $schlSafety->is_subquestion = 0;
        $schlSafety->data = '{"items":["5","4","3","2","1"],"labels":["Ja, alltid","Ja, n\u00e4stan alltid","Ja, f\u00f6r det mesta","Nej, oftast inte","Nej, inte alls"],"count":5,"toggle_value":"1"}';
        $schlSafety->save();

        // $schlAtmosphere = QuestionnaireQuestion::find(196);
        // $schlAtmosphere->data = '{"items":["1","2","3","4","5"],"labels":["Nej, inte alls","Nej, oftast inte","Ja, f\u00f6r det mesta","Ja, n\u00e4stan alltid","Ja, alltid"],"count":5,"toggle_value":"1"}';
        // $schlAtmosphere->save();
        QuestionnaireQuestion::destroy(196);

        $schlSituationInfo = QuestionnaireQuestion::find(200);
        $schlSituationInfo->data = '{"items":["5","4","3","2","1"],"labels":["Ja, alltid","Ja, n\u00e4stan alltid","Ja, f\u00f6r det mesta","Nej, oftast inte","Nej, inte alls"],"count":5,"toggle_value":"1"}';
        $schlSituationInfo->save();

        $balance = QuestionnaireQuestion::find(153);
        $balance->has_help = 1;
        $balance->help = 'questionnaire-question-help.label158';
        $balance->save();

        $friends = QuestionnaireQuestion::find(84);
        $friends->data = '{"items":["5","4","3","2","1"],"labels":["Ja, mycket bra","Ja, bra","Ja, ganska bra","Nej, ganska d\u00e5liga","Nej, inte alls"],"count":5}';
        $friends->save();

        $adults = QuestionnaireQuestion::find(90);
        $adults->data = '{"items":["5","4","3","2","1"],"labels":["Ja, mycket bra","Ja, bra","Ja, ganska bra","Nej, ganska d\u00e5liga","Nej, inte alls"],"count":5}';
        $adults->save();

        // schlCalmness
        QuestionnaireQuestion::destroy(103);

        ProfileFactor::where('category_id', 5)->delete();

        $calmness = QuestionnaireQuestion::find(89);
        $calmness->data = '{"items":["5","4","3","2","1"],"labels":["Ja, n\u00e4stan alltid","Ja, oftast","Ja, ganska ofta","Nej, s\u00e4llan","Nej, n\u00e4stan aldrig"],"count":5,"toggle_value":"1"}';
        $calmness->save();

        $physicalText = QuestionnaireQuestion::where('form_name', 'physicalText')->first();
        if (! $physicalText) {
            $physicalText = new QuestionnaireQuestion;
            $physicalText->group_id = 27;
            $physicalText->category_id = 1;
            $physicalText->is_subquestion = 0;
            $physicalText->has_subquestion = 0;
            $physicalText->is_conditional = 0;
            $physicalText->is_part_of_conditional = 0;
            $physicalText->label = 'questionnaire-question-names.label174';
            $physicalText->form_name = 'physicalText';
            $physicalText->description = 'questionnaire-question-desc.label160';
            $physicalText->weight = 0;
            $physicalText->data = '';
        }
        $physicalText->has_help = 1;
        $physicalText->help = 'questionnaire-question-help.label159';
        $physicalText->type_id = 16;
        $physicalText->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('questionnaire_questions', function (Blueprint $table) {
        //     //
        // });
    }
};
