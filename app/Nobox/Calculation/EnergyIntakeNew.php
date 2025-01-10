<?php

declare(strict_types=1);

namespace App\Nobox\Calculation;

class EnergyIntakeNew
{
    public static $options = [
        [
            'name' => 'energyIntakeNewBreakfast',
            'kcal' => [
                0,
                300,
                450,
                700,
            ],
        ],
        [
            'name' => 'energyIntakeNewLunch',
            'kcal' => [
                0,
                300,
                450,
                700,
            ],
        ],
        [
            'name' => 'energyIntakeNewDinner',
            'kcal' => [
                0,
                300,
                450,
                700,
            ],
        ],
    ];
}
