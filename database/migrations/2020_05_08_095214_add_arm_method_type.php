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
        $type->id = 19;
        $type->label = 'elements.group-arm-method';
        $type->template_name = 'form-arm-method';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(19);
        $type->delete();
    }
};
