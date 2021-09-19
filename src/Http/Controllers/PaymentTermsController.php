<?php

namespace Rutatiina\Globals\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class PaymentTermsController extends Controller
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
            'Due on Receipt' => 'Due on Receipt',
            'Net7' => 'Net 7',
            'Net10' => 'Net 10',
            'Net30' => 'Net 30',
            'Net60' => 'Net 60',
            'Net90' => 'Net 90',
            'EOM' => 'EOM',
        ];
    }

    private static function selectOptions ()
    {
        $response = [];
        foreach (static::formats() as $key => $value) {
            $response[] = [
                'value' => $key,
                'text' => $value
            ];
        }
        return $response;
    }

}
