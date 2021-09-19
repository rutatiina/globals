<?php

namespace Rutatiina\Globals\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class DateFormatsController extends Controller
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

    private static function formats ()
    {
        return [
            'yyyy-dd-mm' => 'yyyy-dd-mm [2019-10-28]'
        ];
    }

    private static function selectOptions ()
    {
        $response = [];
        foreach (static::formats() as $code => $language) {
            $response[] = [
                'value' => $code,
                'text' => $language
            ];
        }
        return $response;
    }

}
