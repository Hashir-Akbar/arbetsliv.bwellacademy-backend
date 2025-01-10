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
        $type->id = 22;
        $type->label = 'elements.group-energy-intake';
        $type->template_name = 'form-energy-intake';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(22);
        $type->delete();
    }
};
