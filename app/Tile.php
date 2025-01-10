<?php

namespace App;

class Tile
{
    public static function all()
    {
        $tiles = [];

        $tiles['physical'] = ['page' => 1, 'name' => 'physical', 'label' => 'sidebar.physical', 'icon' => 'sports'];
        $tiles['physical_questions'] = ['page' => 2, 'name' => 'physical_questions', 'label' => 'sidebar.physical_questions', 'icon' => 'sports'];
        $tiles['wellbeing'] = ['page' => 3, 'name' => 'wellbeing', 'label' => 'sidebar.wellbeing', 'icon' => 'health'];
        $tiles['drugs'] = ['page' => 4, 'name' => 'drugs', 'label' => 'sidebar.drugs', 'icon' => 'appearance'];
        $tiles['energy'] = ['page' => 5, 'name' => 'energy', 'label' => 'sidebar.energy', 'icon' => 'food'];
        $tiles['activities'] = ['page' => 6, 'name' => 'activities', 'label' => 'sidebar.activities', 'icon' => 'activities'];
        if (config('fms.type') == 'work') {
            $tiles['work'] = ['page' => 7, 'name' => 'work', 'label' => 'sidebar.work', 'icon' => 'school'];
        } else {
            $tiles['school'] = ['page' => 7, 'name' => 'school', 'label' => 'sidebar.school', 'icon' => 'school'];
        }
        $tiles['kasam'] = ['page' => 8, 'name' => 'kasam', 'label' => 'sidebar.kasam', 'icon' => 'family'];

        return $tiles;
    }
}
