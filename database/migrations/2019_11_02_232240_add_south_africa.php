<?php

use App\Country;
use App\County;
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
        $country = new Country;
        $country->label = 'countries.south_africa';
        $country->save();

        $county = new County;
        $county->country_id = $country->id;
        $county->label = 'South Africa';
        $county->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $country = Country::where('label', 'countries.south_africa')->first();
        if ($country) {
            $counties = County::where('country_id', $country->id)->get();
            foreach ($counties as $county) {
                $county->delete();
            }
            $country->delete();
        }
    }
};
