<?php

namespace App\Console\Commands;

use App\Profile;
use App\User;
use Illuminate\Console\Command;

class UsersFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix users';

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
        $users = User::all();

        foreach ($users as $user) {
            // trim name
            $user->first_name = trim($user->first_name);
            $user->last_name = trim($user->last_name);

            // guess birth date if missing
            if ($user->isStudent()) {
                $valid = true;

                if ($user->guessed_birth_date) {
                    $valid = false;
                }

                if (is_null($user->birth_date)) {
                    $valid = false;
                } else {
                    if ($user->birth_date->year === 1900) {
                        $valid = false;
                    }

                    if ($user->birth_date->year === 1970) {
                        $valid = false;
                    }

                    $profiles = Profile::where('user_id', $user->id)
                        ->orderBy('date', 'asc')
                        ->get();

                    $profile = $profiles->first();
                    if (! is_null($profile)) {
                        $d1 = new \DateTime($profile->date);
                        $d2 = new \DateTime($user->birth_date);

                        $profile_year = intval($d1->format('Y'));
                        if ($profile_year < 2000) {
                            dump($profile);
                        } else {
                            $diff = $d2->diff($d1);
                            $age = $diff->y;
                            if ($age < 7) {
                                $valid = false;
                            }
                        }
                    }
                }

                if (! $valid) {
                    $user->birth_date = $this->guessBirthDate($user);
                    $user->guessed_birth_date = true;
                }
            }

            $user->save();
        }
    }

    private function guessBirthDate($user)
    {
        if (is_null($user->section)) {
            return null;
        }

        if (is_null($user->section->unit)) {
            return null;
        }

        $profiles = Profile::where('user_id', $user->id)
            ->orderBy('date', 'asc')
            ->get();

        $profile = $profiles->last();
        if (is_null($profile)) {
            return null;
        }

        $school_year = $user->section->school_year;
        if ($user->section->unit->school_type === 'unit.secondary') {
            $school_year += 9;
        }
        $guessed_age = $school_year + 6;

        $profile_date = new \DateTime($profile->date);
        $birth_year = intval($profile_date->format('Y')) - $guessed_age;

        $guessed_birth_date = strval($birth_year) . '-07-01';

        return $guessed_birth_date;
    }
}
