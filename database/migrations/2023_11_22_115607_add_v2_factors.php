<?php

use App\QuestionnaireCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        QuestionnaireCategory::create([
            'label' => 'factors.otcDrugs',
            'name' => 'otcDrugs',
            'show_bar' => 1,
            'health' => 1,
            'page_name' => 'drugs',
        ]);

        for ($i = 1; $i <= 7; ++$i) {
            QuestionnaireCategory::create([
                'label' => 'factors.alcoholDrink' . $i,
                'name' => 'alcoholDrink' . $i,
                'show_bar' => 0,
                'health' => 0,
                'page_name' => '',
            ]);
        }

        QuestionnaireCategory::create([
            'label' => 'factors.alcoholDrink',
            'name' => 'alcoholDrink',
            'show_bar' => 1,
            'health' => 1,
            'page_name' => 'drugs',
        ]);

        QuestionnaireCategory::create([
            'label' => 'factors.moneyGames',
            'name' => 'moneyGames',
            'show_bar' => 0,
            'health' => 1,
            'page_name' => 'drugs',
        ]);

        QuestionnaireCategory::create([
            'label' => 'factors.physicalActivity',
            'name' => 'physicalActivity',
            'show_bar' => 0,
            'health' => 1,
            'page_name' => 'physical_questions',
        ]);

        QuestionnaireCategory::create([
            'label' => 'factors.energyWork',
            'name' => 'energyWork',
            'show_bar' => 0,
            'health' => 1,
            'page_name' => 'physical_questions',
        ]);

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();

        QuestionnaireCategory::where('name', 'energyWork')->delete();
        QuestionnaireCategory::where('name', 'physicalActivity')->delete();
        QuestionnaireCategory::where('name', 'moneyGames')->delete();
        QuestionnaireCategory::where('name', 'alcoholDrink')->delete();

        for ($i = 1; $i <= 7; ++$i) {
            QuestionnaireCategory::where('name', 'alcoholDrink' . $i)->delete();
        }

        QuestionnaireCategory::where('name', 'otcDrugs')->delete();

        DB::commit();
    }
};
