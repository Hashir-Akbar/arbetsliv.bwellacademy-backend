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
        $type->id = 20;
        $type->label = 'elements.group-fit-cooper';
        $type->template_name = 'form-fitness-cooper';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(20);
        $type->delete();
    }
};
