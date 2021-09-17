<?php

namespace Rutatiina\Http\Controllers\Globals;

use App;
use App\Http\Controllers\Controller;
use DateTimeZone;

class TimeZonesController extends Controller
{

    public function __construct()
    {}

    public function index($options)
    {
        switch ($options) {
            case 'select-options':
                return $this->selectOptions();
                break;

            default:
                return [];
                break;
        }
    }

    private static function timeZones ()
    {
        $timeZones = [];

        foreach (DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $time_zone) {
            $timeZones[] = $time_zone;
        }

        return $timeZones;
    }

    private static function selectOptions ()
    {
        $response = [];
        foreach (static::timeZones() as $time_zone) {
            $response[] = [
                'value' => $time_zone,
                'text' => $time_zone
            ];
        }
        return $response;
    }

}
