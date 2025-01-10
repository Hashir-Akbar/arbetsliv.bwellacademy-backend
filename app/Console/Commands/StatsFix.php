<?php

namespace App\Console\Commands;

use App\ProfileValue;
use Illuminate\Console\Command;

class StatsFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // length
        $values = ProfileValue::where('name', 'length')->get();
        foreach ($values as $value) {
            if (is_null($value->value)) {
                continue;
            }
            // use null instead of 0
            if ($value->value == 0) {
                $value->value = null;
                $value->save();
            }
            // m to cm
            if ($value->value > 0 && $value->value < 3) {
                $value->value = $value->value * 100;
                $value->save();
            }
            // too high
            if ($value->value > 300) {
                $value->value = null;
                $value->save();
            }
            // swap length and weight?
            if ($value->value < 100) {
                $weight = ProfileValue::where('profile_id', $value->profile_id)->where('name', 'weight')->first();
                if (! is_null($weight) && $weight->value > 100) {
                    $tmp = $weight->value;

                    $weight->value = $value->value;
                    $weight->save();

                    $value->value = $tmp;
                    $value->save();
                }
            }
            // too low
            if ($value->value < 100) {
                $value->value = null;
                $value->save();
            }
        }

        // weight
        $values = ProfileValue::where('name', 'weight')->get();
        foreach ($values as $value) {
            if (is_null($value->value)) {
                continue;
            }
            // use null instead of 0
            if ($value->value == 0) {
                $value->value = null;
                $value->save();
            }
            // too high
            if ($value->value > 300) {
                $value->value = null;
                $value->save();
            }
            // too low
            if ($value->value < 30) {
                $value->value = null;
                $value->save();
            }
        }
    }
}
