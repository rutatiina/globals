<?php

namespace Rutatiina\Http\Controllers\Globals;

use App;
use App\Http\Controllers\Controller;

class SalutationsController extends Controller
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
            'Mr',
            'Miss',
            'Ms',
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
