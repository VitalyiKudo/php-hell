<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreOperator extends FormRequest
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
            'source_id' => 'numeric|max:255',
            'name' => 'required|string|max:255',
            'web_site' => 'string|max:255',
            'email' => 'email|max:255',
            'phone' => 'string|max:255',
            'mobile' => 'string|max:255',
            'fax' => 'string|max:255',
            'address' => 'min:5',
        ];
    }
}
