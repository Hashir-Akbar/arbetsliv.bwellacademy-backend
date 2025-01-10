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
        $type = ElementType::findOrFail(9);
        $type->template_name = 'form-fit-method';
        $type->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type = ElementType::findOrFail(9);
        $type->template_name = 'form-method';
        $type->save();
    }
};
