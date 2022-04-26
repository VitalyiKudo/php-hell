<?php

namespace App\Http\Requests\Admin;

class UpdateEmptyLeg extends StoreEmptyLeg
{
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
            'dateDeparture' => 'required|date',
            'active' => 'nullable|numeric',
        ];
    }
}
