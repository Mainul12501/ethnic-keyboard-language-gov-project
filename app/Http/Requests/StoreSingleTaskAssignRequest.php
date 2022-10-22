<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSingleTaskAssignRequest extends FormRequest
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
            'user_id' =>'required',
            'language_id' =>'required',
            'district' =>'required',
             /*'upazila' =>'required',
             'union' =>'required',*/
            // 'village' =>'required',
            // 'total_sample' =>'required',
            // 'start_date' =>'required|date',
            // 'end_date' =>'required|date',
            'topic_id' =>'required',
            'spontaneous_id' =>'required',
        ];
    }
}
