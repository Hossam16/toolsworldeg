<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\BusinessSetting;
use App\Currency;

class SettingsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name' => $data->name,
                    'logo' => $data->logo,
                    'facebook' => $data->facebook,
                    'twitter' => $data->twitter,
                    'instagram' => $data->instagram,
                    'youtube' => $data->youtube,
                    'google_plus' => $data->google_plus,
                    'currency' => [
                        'name' => getCurrencies()->where("id",getBusinessSetting()->where('type', 'system_default_currency')->first()->value)->first()->name,
                        'symbol' => getCurrencies()->where("id",getBusinessSetting()->where('type', 'system_default_currency')->first()->value)->first()->symbol,
                        'exchange_rate' => (double) $this->exchangeRate(getCurrencies()->where("id",getBusinessSetting()->where('type', 'system_default_currency')->first()->value)->first()),
                        'code' => getCurrencies()->where("id",getBusinessSetting()->where('type', 'system_default_currency')->first()->value)->first()->code
                    ],
                    'currency_format' => $data->currency_format
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    public function exchangeRate($currency){
        $base_currency = getCurrencies()->find(getBusinessSetting()->where('type', 'system_default_currency')->first()->value);
        return $currency->exchange_rate/$base_currency->exchange_rate;
    }
}
