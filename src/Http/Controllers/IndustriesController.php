<?php

namespace Rutatiina\Globals\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class IndustriesController extends Controller
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
            'Information technology'
        ];
    }

    private static function selectOptions ()
    {
        $response = [];
        foreach (static::formats() as $key => $value) {
            $response[] = [
                'value' => $value,
                'text' => $value
            ];
        }
        return $response;
    }

}
