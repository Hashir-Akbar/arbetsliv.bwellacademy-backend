<?php

use App\Factors;
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
        DB::table('category_connections')->truncate();

        $connections = [
            Factors::Agility->value => [
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Stress->value,
            ],
            Factors::Strength->value => [
                Factors::Agility->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::BodySympt->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
            ],
            Factors::Balance->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Posture->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
            ],
            Factors::Motor->value => [
                Factors::Strength->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
            ],
            Factors::Posture->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Headache->value,
                Factors::Media->value,
            ],
            Factors::Fitness->value => [
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::PhysicalTraining->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodFluid->value,
                Factors::Freetime->value,
            ],
            Factors::PhysicalActivity->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodFluid->value,
                Factors::Freetime->value,
            ],
            Factors::Sitting->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::Freetime->value,
                Factors::Media->value,
            ],
            Factors::BodySat->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodSweets->value,
                Factors::FoodEnergyDrinks->value,
                Factors::Freetime->value,
                Factors::Media->value,
            ],
            Factors::Health->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Balance->value,
                Factors::Motor->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodSweets->value,
                Factors::FoodFluid->value,
                Factors::FoodEnergyDrinks->value,
                Factors::Freetime->value,
                Factors::Media->value,
                Factors::Friends->value,
            ],
            Factors::BodySympt->value => [
                Factors::Agility->value,
                Factors::Strength->value,
                Factors::Posture->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::Freetime->value,
                Factors::Media->value,
            ],
            Factors::Relaxed->value => [
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodFluid->value,
                Factors::Media->value,
            ],
            Factors::Stomachache->value => [
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodSweets->value,
                Factors::Media->value,
                Factors::Friends->value,
            ],
            Factors::Headache->value => [
                Factors::Agility->value,
                Factors::Posture->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodFruit->value,
                Factors::FoodSweets->value,
                Factors::FoodFluid->value,
                Factors::FoodEnergyDrinks->value,
                Factors::Media->value,
            ],
            Factors::Sleep->value => [
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodSweets->value,
                Factors::FoodFluid->value,
                Factors::FoodEnergyDrinks->value,
                Factors::Freetime->value,
                Factors::Media->value,
            ],
            Factors::Stress->value => [
                Factors::Agility->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodEnergyBalance->value,
                Factors::FoodFluid->value,
                Factors::FoodEnergyDrinks->value,
                Factors::Freetime->value,
                Factors::Media->value,
                Factors::Friends->value,
            ],
            Factors::Smoking->value => [
                Factors::Strength->value,
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::Snuffing->value => [
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::Alcohol->value => [
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::FoodHabits->value => [
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::FoodEnergyBalance->value => [
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Smoking->value,
                Factors::Snuffing->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::FoodSweets->value,
                Factors::Media->value,
            ],
            Factors::FoodFruit->value => [
                Factors::Headache->value,
            ],
            Factors::FoodSweets->value => [
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::FoodEnergyBalance->value,
            ],
            Factors::FoodFluid->value => [
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
            ],
            Factors::FoodEnergyDrinks->value => [
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
            ],
            Factors::Freetime->value => [
                Factors::Fitness->value,
                Factors::PhysicalTraining->value,
                Factors::PhysicalActivity->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::Alcohol->value,
                Factors::FoodHabits->value,
                Factors::Media->value,
                Factors::Friends->value,
            ],
            Factors::Media->value => [
                Factors::Posture->value,
                Factors::Sitting->value,
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::BodySympt->value,
                Factors::Relaxed->value,
                Factors::Stomachache->value,
                Factors::Headache->value,
                Factors::Sleep->value,
                Factors::Stress->value,
                Factors::FoodEnergyBalance->value,
                Factors::Freetime->value,
                Factors::Friends->value,
            ],
            Factors::Friends->value => [
                Factors::Health->value,
                Factors::Stomachache->value,
                Factors::Stress->value,
                Factors::Freetime->value,
                Factors::Media->value,
            ],
        ];

        if (config('fms.type') === 'school') {
            $connections[Factors::Agility->value][] = Factors::Performance->value;
            $connections[Factors::BodySat->value][] = Factors::Kasam->value;

            $connections[Factors::Health->value][] = Factors::Adults->value;
            $connections[Factors::Health->value][] = Factors::Performance->value;
            $connections[Factors::Health->value][] = Factors::Wellbeing->value;
            $connections[Factors::Health->value][] = Factors::Kasam->value;

            $connections[Factors::Relaxed->value][] = Factors::Performance->value;
            $connections[Factors::Relaxed->value][] = Factors::Wellbeing->value;

            $connections[Factors::Sleep->value][] = Factors::Adults->value;
            $connections[Factors::Sleep->value][] = Factors::Performance->value;
            $connections[Factors::Sleep->value][] = Factors::Wellbeing->value;

            $connections[Factors::FoodEnergyBalance->value][] = Factors::Adults->value;
            $connections[Factors::FoodEnergyBalance->value][] = Factors::Performance->value;
            $connections[Factors::FoodEnergyBalance->value][] = Factors::Wellbeing->value;

            $connections[Factors::Freetime->value][] = Factors::Adults->value;
            $connections[Factors::Freetime->value][] = Factors::Wellbeing->value;

            $connections[Factors::Media->value][] = Factors::Adults->value;
            $connections[Factors::Media->value][] = Factors::Performance->value;
            $connections[Factors::Media->value][] = Factors::Wellbeing->value;

            $connections[Factors::Friends->value][] = Factors::Wellbeing->value;
            $connections[Factors::Friends->value][] = Factors::Safety->value;

            $connections[Factors::Adults->value] = [
                Factors::Health->value,
                Factors::Sleep->value,
                Factors::FoodEnergyBalance->value,
                Factors::Freetime->value,
                Factors::Media->value,
                Factors::Safety->value,
            ];

            $connections[Factors::Performance->value] = [
                Factors::Health->value,
                Factors::Relaxed->value,
                Factors::FoodEnergyBalance->value,
                Factors::Media->value,
                Factors::Safety->value,
                Factors::Kasam->value,
            ];

            $connections[Factors::Wellbeing->value] = [
                Factors::Sleep->value,
                Factors::FoodEnergyBalance->value,
                Factors::Freetime->value,
                Factors::Friends->value,
                Factors::Adults->value,
                Factors::Safety->value,
                Factors::Kasam->value,
            ];

            $connections[Factors::Safety->value] = [
                Factors::Friends->value,
                Factors::Adults->value,
                Factors::Performance->value,
                Factors::Wellbeing->value,
                Factors::Kasam->value,
            ];

            $connections[Factors::Kasam->value] = [
                Factors::BodySat->value,
                Factors::Health->value,
                Factors::Performance->value,
                Factors::Wellbeing->value,
                Factors::Safety->value,
            ];
        }

        foreach ($connections as $factor => $factors) {
            foreach ($factors as $secondFactor) {
                DB::table('category_connections')->insert([
                    'category_id' => $factor,
                    'affected_by_id' => $secondFactor,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
