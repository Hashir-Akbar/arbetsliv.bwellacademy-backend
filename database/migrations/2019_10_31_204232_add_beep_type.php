<?php

use App\ElementType;
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
        $type = new ElementType;
        $type->id = 18;
        $type->label = 'elements.group-fit-beep';
        $type->template_name = 'form-fitness-beep';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(18);
        $type->delete();
    }
};
