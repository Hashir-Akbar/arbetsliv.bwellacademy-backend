<?php

namespace App\Console\Commands;

use App\Profile;
use Illuminate\Console\Command;

class StatsRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:refresh {profile?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update profile calculations';

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
        $profile_id = $this->argument('profile');

        if (! empty($profile_id)) {
            $profile = Profile::find($profile_id);
            if (is_null($profile)) {
                printf("could not find profile %s\n", $profile_id);

                return;
            }
            printf("updating profile: %s\n", $profile->id);
            try {
                $profile->calculate();
            } catch (\Exception $e) {
                printf("\rcould not update profile: %s\nexception: %s\n", $profile->id, $e);
            }
        } else {
            // $profiles = Profile::all()->take(50);
            $profiles = Profile::all();

            $i = 1;
            $n = $profiles->count();

            foreach ($profiles as $profile) {
                printf("\rupdating profile %s/%s", $i++, $n);
                try {
                    $profile->calculate();
                } catch (\Exception $e) {
                    printf("\rcould not update profile: %s\nexception: %s\n", $profile->id, $e);
                }
            }
        }

        printf("\ndone\n");
    }
}
