<?php

use App\QuestionnaireLimit;
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
        $strLegs = QuestionnaireLimit::find(2);
        $strLegs->limits = '[[0,28,81,127,179],[0,38,106,164,231]]';
        $strLegs->save();

        $strBack2 = QuestionnaireLimit::find(4);
        $strBack2->limits = '[[0,5,32,59,85],[0,5,32,59,85]]';
        $strBack2->save();

        $strArm5kg = QuestionnaireLimit::find(94);
        $strArm5kg->limits = '[[0,9,20,29,39],[0,4,30,53,78]]';
        $strArm5kg->save();

        $strArm10kg = QuestionnaireLimit::find(95);
        $strArm10kg->limits = '[[0,9,20,29,39],[0,6,16,25,34]]';
        $strArm10kg->save();

        $strAb = QuestionnaireLimit::find(6);
        $strAb->limits = '[[0,11,36,57,81],[0,19,47,71,98]]';
        $strAb->save();

        $balance = QuestionnaireLimit::find(9);
        $balance->limits = '[[0,1,2,5,7],[0,1,2,5,7]]';
        $balance->save();
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
