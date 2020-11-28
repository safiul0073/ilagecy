<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplier extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'api' => 'required',
            'created_by' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'note' => 'nullable',
        ];
    }
}
