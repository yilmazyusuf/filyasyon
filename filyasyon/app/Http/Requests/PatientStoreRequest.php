<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
            'name' => 'required',
            'tckn' => 'required|unique:patients',
            'age' => 'required',
            'gsm' => 'required',
            'detection_date' => 'required|date_format:d/m/Y',
            'bt_id' => 'required',
            'village_id' => 'required',
            'neighborhood_id' => 'required',
            'address' => 'required',
            'contact_place_id' => 'required',
            'contact_origin_id' => 'required',
            'contacted_count' => 'required',
            'contacted_pcr_positive_count' => 'required',
            'patient_status_id' => 'required',
            'ex_date' => 'required_if:patient_status_id,8|nullable|date_format:d/m/Y',
            'health_personnel_profession_id' => 'required_if:is_health_personnel,1',
            'contact_origin_patient_id' => 'required_if:contact_origin_id,1',
            'relationship_to_main_case_id' => 'required_if:contact_origin_id,1',
            'healing_date' => 'required_if:patient_status_id,1,2,3,4,7|nullable|date_format:d/m/Y',
            'pcr_status' => 'required_without:contacted_status',
            'contacted_status' => 'required_without:pcr_status',

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
            'name.required' => 'Hasta ismi ve soyismi belirtiniz.',
            'tckn.required' => 'Hasta T.C. no belirtiniz.',
            'tckn.unique' => 'Girilen T.C. no ile kayıtlı hasta mevcut.',
            'age.required' => 'Yaşını yazınız.',
            'gsm.required' => 'Telefon numarası  yazınız.',
            'detection_date.required' => 'Tespit tarihi belirtiniz.',
            'detection_date.date' => 'Geçersiz tarih.',
            'bt_id.required' => 'BT seçiniz.',
            'village_id.required' => 'Mahalle/Köy seçiniz',
            'neighborhood_id.required' => 'Mahalle seçiniz',
            'address.required' => 'Adres yazınız',
            'contact_place_id.required' => 'Temas yeri seçiniz.',
            'contact_origin_id.required' => 'Temas orjin seçiniz.',
            'contacted_count.required' => 'Temaslı sayısı belirtiniz.',
            'contacted_pcr_positive_count.required' => 'Temaslılardan PCR pozitif sayısı belirtiniz.',
            'patient_status_id.required' => 'Durumu seçiniz.',
            'health_personnel_profession_id.required_if' => 'Sağlık  personeli ise  görevini seçiniz.',
            'contact_origin_patient_id.required_if' => 'Asıl vaka adı soyadı seçiniz.',
            'relationship_to_main_case_id.required_if' => 'Asıl vakaya yakınlık seçiniz.',
            'ex_date.required_if' => 'EX tarihi beliritiniz.',
            'ex_date.date' => 'Geçersiz tarih.',
            'healing_date.required_if' => 'İyileşme tarihi beliritiniz.',
            'healing_date.healing_date' => 'Geçersiz tarih.',
            'pcr_status.required_without' => 'PCR veya Temasli seciniz',
            'contacted_status.required_without' => 'PCR veya Temasli seciniz',
        ];
    }
}
