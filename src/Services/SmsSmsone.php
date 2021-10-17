<?php

namespace Rutatiina\Globals\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\SmsOutbox;
use Rutatiina\User\Models\User;

//Orignally by tamaledn@gmail.com
class SmsSmsone
{

    protected static $only_instance;
    public static $rg_errors;

    public static $phoneNumber;
    public static $message;
    public static $subject = null;

    //these variables are for the aggregator
    public static $main_url = "http://apidocs.speedamobile.com/api/";// For Live request

    //http://mysms.trueafrican.com/v1/api/esme/send
    public static $uname = "";
    public static $pwd = "";
    public static $application_name = '';

    //these variables are for the site

    private static $site_name = '';
    private static $site_email = '';
    private static $logo = '';

    //these variables are for smtp email

    private static $smtp_host = '';
    private static $smtp_user = '';
    private static $smtp_pass = '';

    function __construct()
    {
        self::$site_name    = env("site_name", "testing");
        self::$uname        = env("sms_username", "testing");
        self::$pwd          = env("sms_password", "testing");
        self::$application_name = env("sms_sender_id", "testing");
        // self::$site_email = env("contact_email", "testing");
        //self::$logo = env("site_logo", "testing");

    }

    protected static function getSelf()
    {
        if (static::$only_instance === null)
        {
            static::$only_instance = new SmsSmsone;
        }
        return static::$only_instance;
    }

    public static function phoneNumber($phoneNumber)
    {
        static::$phoneNumber = $phoneNumber;
        return static::getSelf();
    }

    public static function message($message)
    {
        static::$message = $message;
        return static::getSelf();
    }

    public static function subject($subject)
    {
        static::$subject = $subject;
        return static::getSelf();
    }

    public static function send()
    {

        if (!empty(static::$phoneNumber)) {

            //verify $phoneNumber number


            $q = SmsOutbox::where('phone_number', static::$phoneNumber)->where('message', static::$message)->first();

            if (!isset($q->id)) {

                $send_values = [
                    "api_id" => self::$uname,
                    "api_password" => self::$pwd,
                    "sms_type" => 'T',
                    "encoding" => 'T',
                    "sender_id" => self::$application_name,
                    "phonenumber" => static::$phoneNumber,
                    "templateid" => null,
                    "textmessage" => static::$message
                ];


                $sent = self::postToAggregator('SendSMS', $send_values);

                //var_dump($sent); exit;

                $output = json_decode($sent);

                if (isset($output->status)) {

                    if ($output->status == 'S') {

                        $subject = isset($subject) ? $subject : self::$site_name;

                        $smsOutbox                  = new SmsOutbox;
                        $smsOutbox->tenant_id       = Auth::user()->tenant->id;
                        $smsOutbox->user_id         = Auth::id();
                        $smsOutbox->phone_number    = static::$phoneNumber;
                        $smsOutbox->subject         = static::$subject;
                        $smsOutbox->m_type          = 'SMS';
                        $smsOutbox->message         = static::$message;
                        $smsOutbox->contact_id      = User::find(Auth::id())->contact->id;

                        $smsOutbox->save();

                        return $output;

                    } else {

                        return $output;
                    }
                } else {
                    return $output;
                }


            } else {
                $output = 'Message has already been sent';
            }
        }

        return $output;
    }

    /**
     * @param string $method
     * @param $values
     * @return mixed
     *
     *
     * [status] => FAILED [code] => 204 [message] => Missing required parameters
     */

    private static function postToAggregator($method = '', $values)
    {
        //$output->status == 'S'

        if (App::environment('local')) {

            $output = json_encode(['status' => 'S']);

        } else {

            $RequestJson = json_encode($values, JSON_PRETTY_PRINT);
            $url = self::$main_url . $method; // where you want to post data

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $RequestJson,
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $output = "cURL Error #:" . $err;
            } else {
                $output = $response;
            }

        }
        return $output; // show output
    }

}

