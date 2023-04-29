<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' =>'required',
            'logo' => 'required',
            'website' => 'required',
            'founded' => 'required',
            'industry_id' => 'required',
            'employees' => 'required',
            'revenue' =>   'required',
            'description' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'mission' => 'required',
        ];
    }
}
