<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientVaccinesRequest extends FormRequest {

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
            'vaccines.0' => 'date_format:d/m/Y|before_or_equal:today',
            'vaccines.1' => 'nullable|date_format:d/m/Y|before_or_equal:today',
            'vaccines.2' => 'nullable|date_format:d/m/Y|before_or_equal:today',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vaccines.0.date_format' => 'Asi tarihini giriniz.',
            'vaccines.0.before_or_equal' => 'Ileri tarihli asi giremezsiniz.',
            'vaccines.1.before_or_equal' => 'Ileri tarihli asi giremezsiniz.',
            'vaccines.2.before_or_equal' => 'Ileri tarihli asi giremezsiniz.',
        ];
    }
}
