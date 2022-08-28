<?php

//Global routes
Route::get('global/notifications/{options}', 'Rutatiina\Globals\Http\Controllers\NotificationController@index');
Route::get('global/services/{options}', 'Rutatiina\Globals\Http\Controllers\ServicesController@index');
Route::get('global/currencies/{options}', 'Rutatiina\Globals\Http\Controllers\CurrenciesController@index');
Route::get('global/countries/{options}', 'Rutatiina\Globals\Http\Controllers\CountriesController@index');
Route::get('global/languages/{options}', 'Rutatiina\Globals\Http\Controllers\LanguagesController@index'); //global/languages/select-options
Route::get('global/date-formats/{options}', 'Rutatiina\Globals\Http\Controllers\DateFormatsController@index'); //global/date-formats/select-options
Route::get('global/industries/{options}', 'Rutatiina\Globals\Http\Controllers\IndustriesController@index'); //global/industries/select-options
Route::get('global/time-zones/{options}', 'Rutatiina\Globals\Http\Controllers\TimeZonesController@index'); //global/time-zones/select-options
Route::get('global/payment-terms/{options}', 'Rutatiina\Globals\Http\Controllers\PaymentTermsController@index'); //global/payment-terms/select-options
Route::get('global/salutations/{options}', 'Rutatiina\Globals\Http\Controllers\SalutationsController@index'); //global/salutations/select-options
//Global routes

