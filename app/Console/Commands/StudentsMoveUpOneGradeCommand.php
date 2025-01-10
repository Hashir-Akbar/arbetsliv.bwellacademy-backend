<?php

namespace App\Console\Commands;

use App\Customer;
use App\Section;
use DB;
use Illuminate\Console\Command;

class StudentsMoveUpOneGradeCommand extends Command
{
    protected $signature = 'students:move-up-one-grade';

    protected $description = 'Moves students up one grade. To be run once per year between school years (scheduled in july)';

    public function handle(): void
    {
        if(config('fms.type') !== 'school')
        {
            $this->info("Non school environment detected. Aborting!");
            return;
        }

        // TODO: Filter out disabled customers
        $customers = Customer::query()->get();

        $this->info("Moving students up one grade...");

        foreach($customers as $customer)
        {
            // TODO: Filter out disabled units
            foreach($customer->units as $unit)
            {
                $sections = $unit->sections()->whereNull('archived_at')->get();

                if(!$sections->count()) continue;

                $isPrimarySchool = $unit->school_type === 'unit.primary';
                $maxGrade = $isPrimarySchool ? 9 : 4;

                $this->info($customer->name . ", " . $unit->name . " - " . $sections->count());

                DB::beginTransaction();

                $this->withProgressBar($sections, function(Section $section) use($maxGrade) {
                    if ($section->school_year >= $maxGrade)
                    {
                        $section->update(['archived_at', now()]);
                    }
                    else
                    {
                        $section->increment('school_year', 1);
                    }
                });

                echo "\n\n";

                DB::commit();
            }
        }

        $this->info("Done!");
    }
}
