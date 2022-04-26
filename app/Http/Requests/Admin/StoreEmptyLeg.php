<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmptyLeg extends FormRequest
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
            'icaoDeparture' => 'required|string|max:12',
            'geoNameIdCityDeparture' => 'nullable|numeric',
            'icaoArrival' => 'required|string|max:12',
            'geoNameIdCityArrival' => 'nullable|numeric',
            'operatorEmail' => 'required|email|max:255',
            'typePlane' => 'required|string|max:20',
            'price' => 'required|numeric',
            'dateDeparture' => 'required|date|after:today',
            'active' => 'nullable|numeric',
        ];
    }
}
