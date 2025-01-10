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
        $type->id = 21;
        $type->label = 'elements.group-energy-needs';
        $type->template_name = 'form-energy-needs';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(21);
        $type->delete();
    }
};
