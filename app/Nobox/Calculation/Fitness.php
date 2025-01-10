<?php

namespace App\Nobox\Calculation;

use Illuminate\Support\Facades\Log;

class Fitness
{
    /**
     * [stepTest description]
     *
     * @param  [type] $weight [description]
     * @param  [type] $pulse  [description]
     * @param  [type] $sex    [description]
     * @param  [type] $height bench height
     * @return [type]         [description]
     */
    public static function stepTest($weight, $pulse, $sex, $height)
    {
        if ($sex == 'F') {
            $pulse -= 10;
        }

        if ($height == 33) {
            $a = 2.9030802397385595E-02;
            $b = 5.6690988015881736E+01;
            $c = -7.3246891833393164E+00;
            $d = -9.0678564070309517E+02;
            $e = 1.2473627910115420E+03;
            $f = -2.2353230313763575E-01;
        } elseif ($height == 40) {
            $a = 1.8057135178381842E-02;
            $b = -9.0454236147987160E+01;
            $c = -3.4232103173081398E+00;
            $d = 1.2590598155376956E+04;
            $e = 1.0884505241170632E+03;
            $f = 1.6875183802297727E-01;
        } else {
            Log::error('stepTest: ' . $height . ' is not a valid bench height');

            return 0;
        }

        $out = $a * $weight;
        $out += $b * pow($pulse, -1.0);
        $out += $c * pow($pulse, -1.0) * $weight;
        $out += $d * pow($pulse, -2.0);
        $out += $e * pow($pulse, -2.0) * $weight;
        $out += $f;

        return $out;
    }

    public static function bicycle($pulse, $watts, $sex)
    {
        if ($sex == 'M') {
            $a = -5.2622510135373695E+00;
            $b = 1.9928736845562137E-02;
            $c = -4.9820088952055280E-02;
            $d = -2.9535099342772635E-02;
            $e = 2.6215981041062793E-03;
        } else {
            $a = -9.3834679135267773E-01;
            $b = 1.6026593849307390E-03;
            $c = -2.1434744078972043E-02;
            $d = -1.4232403302161975E-02;
            $e = 2.9722833314120457E-05;
        }

        $out = ($a + $b * $pulse + $c * $watts) /
               (1 + $d * $pulse + $e * $watts);

        return $out;
    }

    public static function ageCorrection($o2lmin, $age)
    {
        // ålderskorrigera
        return $o2lmin * (1.22254221388368 - 9.58818011257038E-03 * $age);
    }

    public static function o2mlkg($o2lmin, $weight)
    {
        return $o2lmin * 1000.0 / $weight;
    }

    public static function o2lmin($o2mlkg, $weight)
    {
        return $o2mlkg / 1000.0 * $weight;
    }
}
