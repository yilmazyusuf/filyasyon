<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
            'tckn' => 'required|unique:patients,tckn,' . $this->route('patient'),
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
            'healing_date' => 'required_if:patient_status_id,7|nullable|date_format:d/m/Y',
            'pcr_status' => 'required_without:contacted_status',
            //'pcr_status' => 'prohibited_if:contacted_status,1',
            'contacted_status' => 'required_without:pcr_status',
            //'contacted_status' => 'prohibited_if:pcr_status,1',

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
            'tckn.unique' => 'Girilen T.C. no ile kay??tl?? hasta mevcut.',
            'age.required' => 'Ya????n?? yaz??n??z.',
            'gsm.required' => 'Telefon numaras??  yaz??n??z.',
            'detection_date.required' => 'Tespit tarihi belirtiniz.',
            'detection_date.date' => 'Ge??ersiz tarih.',
            'bt_id.required' => 'BT se??iniz.',
            'village_id.required' => 'Mahalle/K??y se??iniz',
            'neighborhood_id.required' => 'Mahalle se??iniz',
            'address.required' => 'Adres yaz??n??z',
            'contact_place_id.required' => 'Temas yeri se??iniz.',
            'contact_origin_id.required' => 'Temas orjin se??iniz.',
            'contacted_count.required' => 'Temasl?? say??s?? belirtiniz.',
            'contacted_pcr_positive_count.required' => 'Temasl??lardan PCR pozitif say??s?? belirtiniz.',
            'patient_status_id.required' => 'Durumu se??iniz.',
            'health_personnel_profession_id.required_if' => 'Sa??l??k  personeli ise  g??revini se??iniz.',
            'contact_origin_patient_id.required_if' => 'As??l vaka ad?? soyad?? se??iniz.',
            'relationship_to_main_case_id.required_if' => 'As??l vakaya yak??nl??k se??iniz.',
            'ex_date.required_if' => 'EX tarihi beliritiniz.',
            'ex_date.date' => 'Ge??ersiz tarih.',
            'healing_date.required_if' => '??yile??me tarihi beliritiniz.',
            'healing_date.healing_date' => 'Ge??ersiz tarih.',
            'pcr_status.required_without' => 'PCR veya Temasli seciniz',
            'contacted_status.required_without' => 'PCR veya Temasli seciniz',
            'pcr_status.prohibited_if' => 'Temasli evet sectiniz, PCR negatif secilmeli',
            'contacted_status.prohibited_if' => 'PCR pozitif sectiniz, temasli hayir secilmeli',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $patientId = $this->route('patient');
            $patient = Patient::find($patientId);

            if (!$patient) {
                abort(404);
            }

            $patientStatusId = $this->get('patient_status_id');
            $extendedQurantineEndDays = $this->get('extended_qurantine_end_days');
            if ($extendedQurantineEndDays && $patientStatusId == 8) {
                $validator->errors()->add('extended_qurantine_end_days', 'EX kisinin karantina suresini uzatamazsiniz');
            }

            if ($extendedQurantineEndDays && $patientStatusId == 7) {
                $validator->errors()->add('extended_qurantine_end_days', 'Iyilesmis hastanin karantina suresini uzatamazsiniz');
            }

            if ($patientStatusId == 7 && $patient->isQuarantineCompleted === false) {
                $validator->errors()->add('patient_status_id', 'Karantinasi bitmeyen hastayi iyilesti secemezsiniz.');
            }

        });
    }
}
