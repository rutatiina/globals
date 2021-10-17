<?php

namespace Rutatiina\Globals\Services;

use Illuminate\Support\Facades\DB;

class ExchangeRate
{
    public static function internal($base_currency, $quote_currency)
    {
        return 1;
        /*
        if ($base_currency == $quote_currency) {
            return 1;
        } else {
            $row = DB::table('chimbuko_exchange_rate')
                ->where('base_currency', $base_currency)
                ->where('quote_currency', $quote_currency)
                ->first();
            return floatval($row->value);
        }
        */
    }

}
