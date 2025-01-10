<?php

use App\QuestionnaireCategory;
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
        if (config('fms.type') !== 'school') {
            return;
        }

        DB::beginTransaction();

        // Delete old questions
        QuestionnaireQuestion::where('group_id', 19)->delete();

        // Add new categories
        for($i = 1; $i <= 11; $i++) {
            QuestionnaireCategory::create([
                'id' => 98 + $i,
                'label' => 'factors.school' . $i,
                'name' => 'school' . $i,
                'show_bar' => 1,
                'health' => 1,
                'page_name' => 'school',
            ]);
        }

        // Add new questions
        $this->createQuestion(99, 'Ambition', 'Jag har höga ambitioner och vill göra bra resultat i skolan', [
            'Ja i mycket hög grad', 'I ganska hög grad', 'Bara delvis', 'Inte särskilt mycket', 'Inte alls',
        ]);

        $this->createQuestion(100, 'Hanterbarhet', 'Jag klarar mig bra i skolan', [
            'Helt och hållet', 'Inte helt', 'Tillräckligt', 'Nästan inte alls', 'Inte alls',
        ]);

        $this->createQuestion(101, 'Uppskattning', 'Jag känner mig sedd av lärarna', [
            'Alltid', 'Nästan alltid', 'För det mesta', 'Oftast inte', 'Inte alls',
        ]);

        $this->createQuestion(102, 'Trivsel', 'Jag trivs bra i skolan', [
            'Mycket bra', 'Bra', 'Ganska bra', 'Ganska dåligt', 'Dåligt',
        ]);

        $this->createQuestion(103, 'Trygghet', 'Jag känner mig trygg i skolan', [
            'Alltid', 'Nästan alltid', 'För det mesta', 'Oftast inte', 'Inte alls',
        ]);

        $this->createQuestion(104, 'Begriplighet', 'Jag vet vad som förväntas av mig i alla ämnen', [
            'Helt och hållet', 'Inte helt', 'Tillräckligt', 'Nästan inte alls', 'Inte alls',
        ]);

        $this->createQuestion(105, 'Meningsfullhet', 'Mitt liv i skolan känns meningsfullt', [
            'Helt och hållet', 'Inte helt', 'Tillräckligt', 'Nästan inte alls', 'Inte alls',
        ]);

        $this->createQuestion(106, 'Sammanhållning', 'Vi har bra sammanhållning i klassen', [
            'Alltid', 'Nästan alltid', 'För det mesta', 'Oftast inte', 'Inte alls',
        ]);

        $this->createQuestion(107, 'Skolarbetet', 'Jag får det stöd jag behöver i skolan', [
            'Helt och hållet', 'Inte helt', 'Delvis', 'Nästan inte alls', 'Inte alls',
        ]);

        $this->createQuestion(108, 'Arbetsmiljö', 'Arbetsmiljön i skolan är lugn och bra', [
            'Alltid', 'Nästan alltid', 'För det mesta', 'Oftast inte', 'Inte alls',
        ]);

        $this->createQuestion(109, 'Stress', 'Jag känner mig inte stressad i skolan', [
            'Aldrig', 'Nästan aldrig', 'Bara då och då', 'Oftast', 'Alltid',
        ]);

        DB::commit();
    }

    private int $index = 0;

    private function createQuestion(int $categoryId, string $label, string $text, array $options): void {
        QuestionnaireQuestion::create([
            'group_id' => 19,
            'category_id' => $categoryId,
            'is_subquestion' => 0,
            'has_subquestion' => 0,
            'is_conditional' => 0,
            'is_part_of_conditional' => 0,
            'form_name' => 'school' . ($this->index + 1),
            'has_help' => 0,
            'type_id' => 3,
            'data' => '{"items":["5","4","3","2","1"],"labels_sv":["' . $options[0] . '","' . $options[1] . '","' . $options[2] . '","' . $options[3] . '","' . $options[4] . '"],"labels_en":["' . $options[0] . '","' . $options[1] . '","' . $options[2] . '","' . $options[3] . '","' . $options[4] . '"],"count":5,"toggle_value":"1"}',
            'weight' => $this->index,
            'label_sv' => $label,
            'label_en' => null,
            'description_sv' => $text,
            'description_en' => null,
            'help_sv' => null,
            'help_en' => null,
        ]);

        $this->index++;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No down
    }
};
