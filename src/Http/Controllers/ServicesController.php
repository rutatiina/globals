<?php

namespace Rutatiina\Globals\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use Rutatiina\Qbuks\Models\Service;

class ServicesController extends Controller
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

    private static function selectOptions ()
    {
        $services = Service::all();

        $response = [];
        foreach ($services as $service) {
            $response[] = [
                'value' => $service->id,
                'text' => $service->name
            ];
        }
        return $response;
    }

}
