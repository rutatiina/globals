<?php

namespace Rutatiina\Globals\Http\Controllers;

use App;
use Illuminate\Support\Facades\Log;
use Rutatiina\Qbuks\Models\Service;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    public function __construct()
    {}

    public function index($options)
    {
        switch ($options) 
        {
            case 'slack':
                Log::channel('slack')->info('This error notification is to be received by slack');
                return 'Test error message sent to slack.';
                break;

            default:
                return [];
                break;
        }
    }

}
