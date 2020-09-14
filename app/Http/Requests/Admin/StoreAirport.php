<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreAirport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'iata' => 'string|max:3',
            'icao' => 'string|max:4',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'timezone' => 'string|max:255',
        ];
    }
}
