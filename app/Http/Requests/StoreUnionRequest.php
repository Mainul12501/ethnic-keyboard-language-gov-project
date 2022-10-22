<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnionRequest extends FormRequest
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
            'name'=>'required|string|regex:/^[a-zA-Z ]+$/u|unique:unions,name',
            'bn_name'=>'required|string|regex:/^[\p{Bengali} ]{0,100}$/u|unique:unions,bn_name',
            'upazila_id'=>'required',
        ];
    }
}
