<?php

use Illuminate\Support\Facades\Auth;
use Rutatiina\FinancialAccounting\Models\Forex\OpenExchangeRate;

//prepend the folder for mix resources
if (!function_exists('rgMix')) {
    function rgMix($path, $manifestDirectory = '')
    {
        return '/web/assets'.mix($path, $manifestDirectory);
    }
}

if (!function_exists('rg_contact_details_check')) {
    function rg_contact_details_check()
    {
        $user = auth()->user();
        $contact = \Rutatiina\Contact\Models\Contact::find($user->contact_id);

        //$redirect_to = 'contacts/'.$contact->id.'/edit';
        //$redirect_to = 'contacts/edit';
        $redirect_to = 'profile/update';

        if (!$contact) {
            return redirect($redirect_to)->withErrors(['message'=>'Error: please update your details.']);
        }

        //var_dump($contact->country); exit;

        //check if the user country is set
        if (empty($contact->country)) {
            return redirect($redirect_to)->withErrors(['message'=>'Error: Country is required.']);
        }

        //check if the user currency is set
        if (empty($contact->currency)) {
            return redirect($redirect_to)->withErrors(['message'=>'Error: Currency is required.']);
        }

        return true;

    }
}

if (!function_exists('rg_cart')) {
    function rg_cart($id = null, $checkout = false)
    {
        $user = auth()->user();

        if ($id && is_numeric($id)) {
            $cart = \Rutatiina\Shopping\Models\Cart::where('contact_id', $user->contact_id)->where('id', $id)->get();
        } else {
            $cart = \Rutatiina\Shopping\Models\Cart::where('contact_id', $user->contact_id)->where('type', 'add_to_cart')->get();
        }

        $cart_total = 0;

        $cart->available    = collect([]);
        $cart->unavailable  = collect([]);

        foreach ($cart as $key => $value) {

            if ($checkout === true && $value->order->balance <= 0) {
                unset($cart[$key]);
                continue;
            }

            if(strtotime($value->order->closing_date) < time()) {
                $cart->unavailable[] = $value;
                continue; //continue if order closing date has been exceeded
            }

            if (!$value->order) {
                $cart->unavailable[] = $value;
                continue; //continue if order was deleted
            }

            $cart->available[] = $value;

            if ($value->order->balance > 0) {
                $cart_total += ($value->quantity * $value->rate);
            }

        }
        $cart->total = $cart_total;

        return $cart;

    }
}

if (!function_exists('exchangeRate')) {
    function exchangeRate($base_currency, $quote_currency, $api = 'open_exchange_rate')
    {

        if ($base_currency == $quote_currency) {
            return 1;
        }

        if ($api == 'open_exchange_rate') {

            $openExchangeRate = OpenExchangeRate::latest()->first();

            if ($openExchangeRate) {

                $openExchangeRate->rates = json_decode($openExchangeRate->rates, true);

                if (isset($openExchangeRate->rates[$base_currency]) && isset($openExchangeRate->rates[$quote_currency])) {

                    $rate = $openExchangeRate->rates[$openExchangeRate->base] * $openExchangeRate->rates[$quote_currency]; //Rate quote currency to base
                    $rate = ($rate / $openExchangeRate->rates[$base_currency]);

                    //print_r($rate);

                    return $rate;
                }
                else {
                    return 0;
                }

            }
            else {
                return false;
            }

        }
        else {
            return false;
        }
    }
}

if (!function_exists('exchangeRates')) {
    function exchangeRates($currencies, $tenantBaseCurrency)
    {
        $exchangeRates = [];
        //$exchangeRates[$contact->currency] = static::exchangeRate($contact->currency, Auth::user()->tenant->base_currency);
        foreach ($currencies as $currency) {
            $exchangeRate = exchangeRate($currency, $tenantBaseCurrency);
            $exchangeRates[$currency] = round($exchangeRate, 5);
        }
        //print_r($exchangeRates); exit;
        return $exchangeRates;
    }
}

if (!function_exists('humanize')) {
    function humanize($str)
    {
        return ucwords(str_replace(array('_', '-'), ' ', $str));
    }
}