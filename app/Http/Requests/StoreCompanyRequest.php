<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' =>'required',
            'logo' => 'required',
            'website' => 'required',
            'foundation_year' => 'required',
            'industry' => 'required',
            'employees' => 'required',
            'revenue' => 'required',
            'description' => 'required',
            'city' =>        'required',
            'country_code' => 'required',
            'address' => 'required',
            'mission' => 'required',
        ];
    }
}
