<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CustomOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'flightModel' => 'required|string|nullable',

            'startPoint' => 'required|string|nullable',
            'endPoint' => 'required|string|nullable',
            'flightDate' => 'required|date:m/d/Y',
            'aircraft' => 'string|nullable',
            'aircraftOne' => 'string|nullable',
            'aircraftTwo' => 'string|nullable',

            'fromStopPoint' => 'string|nullable',
            'toStopPoint' => 'string|nullable',
            'stopFlightDate' => 'nullable|date:m/d/Y',

            'fromReturnPoint' => 'string|nullable',
            'toReturnPoint' => 'string|nullable',
            'returnFlightDate' => 'nullable|date:m/d/Y',

            'pax' => 'required|int',
            'pets' => 'int',
            'bags' => 'int',
            'lbags' => 'int',

            'wifi' => 'boolean',
            'lavatory' => 'boolean',
            'disabilities' => 'int',
            'catering' => 'boolean',

            'comment' => 'string|nullable'
        ];
    }
}
