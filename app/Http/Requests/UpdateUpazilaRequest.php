<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUpazilaRequest extends FormRequest
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
            'name'=>['required', 'string', 'regex:/^[a-zA-Z ]+$/u',Rule::unique('upazilas', 'name')->ignore($this->upazila)],
            'bn_name'=>['required', 'string','regex:/^[\p{Bengali} ]{0,100}$/u', Rule::unique('upazilas', 'bn_name')->ignore($this->upazila)],
            'district_id'=>'required',
        ];
    }
}
