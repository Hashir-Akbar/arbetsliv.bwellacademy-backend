<?php

use App\Mail\CustomMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use JetBrains\PhpStorm\NoReturn;

/*
 * dd() with headers
 */
if (! function_exists('ddh')) {
    #[NoReturn] function ddh(...$vars): void
    {
        header('Access-Control-Allow-Origin: ' . request()->server('HTTP_ORIGIN'));
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');

        dd(...$vars);
    }
}

/**
 * Lägg till querystring i slutet på filnamn för att hantera cache-busting.
 *
 * @param  string  $path
 * @return string
 */
function version($path)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . $path;
    if (file_exists($file)) {
        return $path . '?v=' . filemtime($file);
    }

    return $path;
}

function t($key, $replace = [])
{
    $fallback = App::getLocale() == 'sv' ? 'en' : 'sv';
    if (Lang::has($key)) {
        $result = Lang::get($key, $replace);
    } elseif (Lang::has($key, $fallback)) {
        $result = Lang::get($key, $replace, $fallback);
    } else {
        $result = $key;
    }

    return $result;
}

/**
 * Konvertera en SQL-query till sträng.
 *
 * @return mixed
 */
function query_to_string($query)
{
    $sql = $query->toSql();
    $sqlArray = explode('?', $sql);
    $bindings = $query->getBindings();
    $bindingsCount = count($bindings);

    $i = 0;
    $result = [];
    foreach ($sqlArray as $s) {
        $result[] = $s;

        if ($i >= $bindingsCount) {
            break;
        }

        $b = $bindings[$i++];
        if (is_numeric($b) || is_bool($b)) {
            $result[] = $b;
        } else {
            $result[] = "'" . $b . "'";
        }
    }

    return implode($result);
}

/**
 * Skapa en sex-siffrig kod.
 *
 * @return string
 */
function generate_reg_code()
{
    $str = '';

    for ($i = 0; $i < 6; ++$i) {
        $str .= rand(0, 9);
    }

    return $str;
}

/**
 * Skicka e-post till användare.
 *
 * @param  string  $template
 * @param  string  $subject
 * @param  mixed  $queryData
 * @param  App\User  $user
 * @param  mixed  $templateData
 */
function sendEmailToUser($template, $subject, $queryData, $user, $templateData = [])
{
    $queryString = implode('&', array_map(function ($key, $value) {
        return $key . '=' . urlencode($value);
    }, array_keys($queryData), array_values($queryData)));
    $data = ['queryString' => $queryString];

    // Skapa array med alla värden till mail-mallen
    foreach ($templateData as $key => $value) {
        $data[$key] = $value;
    }

    // // Lägg mailet i kö
    // Mail::queue($template, $data, function($message) use ($subject, $user)
    // {
    //     $message->to($user->email, $user->full_name());
    //     $message->subject(t($subject));
    // });

    Mail::to($user->email, $user->full_name())->queue(new CustomMail($template, t($subject), $data));
}

/**
 * Hämta alla klasser grupperade på län.
 *
 * @return mixed $counties
 */
function get_all_county_sections()
{
    $counties = [];
    $sectionsQuery = DB::table('sections')
        ->select('unit.county_id', 'sections.*', 'unit.school_type')
        ->join('unit', 'sections.unit_id', '=', 'unit.id')
        ->get();

    // Formatera array
    foreach ($sectionsQuery as $result) {
        if (! isset($counties[$result->county_id])) {
            $counties[$result->county_id] = [];
        }

        $section = $result;
        $counties[$section->county_id][] = ['section' => $section, 'school_type' => $result->school_type];
    }

    return $counties;
}

/**
 * Hämta alla klasser grupperade efter land.
 *
 * @return mixed $countries
 */
function get_all_country_sections()
{
    $countries = [];
    $sectionsQuery = DB::table('sections')
        ->select('counties.country_id', 'unit.county_id', 'sections.*', 'unit.school_type')
        ->join('unit', 'sections.unit_id', '=', 'unit.id')
        ->join('counties', 'unit.county_id', '=', 'counties.id')
        ->get();

    // Formatera array
    foreach ($sectionsQuery as $result) {
        if (! isset($countries[$result->country_id])) {
            $countries[$result->country_id] = [];
        }

        $section = $result;
        $countries[$result->country_id][] = ['section' => $section, 'school_type' => $section->school_type];
    }

    return $countries;
}
