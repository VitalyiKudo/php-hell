<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdministrator extends FormRequest
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
        $administrator = $this->route('administrator');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administrators,email,' . $administrator->id,
            'password' => 'sometimes|string|nullable|string',
        ];
    }
}
