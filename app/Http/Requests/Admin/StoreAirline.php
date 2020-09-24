<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreAirline extends FormRequest
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
            'source_id' => 'numeric|max:191',
            'type' => 'required|string|max:191',
            'reg_number' => 'nullable|string|max:191',
            'category' => 'nullable|string|max:191',
            'homebase' => 'nullable|string|max:191',
            'max_pax' => 'nullable|numeric',
            'yom' => 'nullable|numeric',
            'operator' => 'nullable|string|max:191',
        ];
    }
}
