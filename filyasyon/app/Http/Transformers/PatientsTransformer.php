<?php

namespace App\Http\Transformers;

use App\Models\Patient;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PatientsTransformer extends TransformerAbstract
{

    /**
     * @param HeadlineNews $headlineNews
     *
     * @return  array
     */
    public function transform(Patient $patient)
    {

        $actionButtons = [
            'edit' => [
                'url' => route('patient.edit', [$patient->id]),
                'icon_class' => 'fa-edit',
                'tooltip' => 'Düzenle',
                'required_permission' => 'patient_update',
            ],

            'copy' => [
                'url' => route('patient.edit', [$patient->id]),
                'icon_class' => 'far fa-copy',
                'tooltip' => 'Kopyala',
                'required_permission' => 'patient_update',
            ],
            'vaccines' => [
                'url' => route('patient.vaccines', [$patient->id]),
                'icon_class' => 'fas fa-syringe',
                'tooltip' => 'Aşılar',
                'required_permission' => 'vaccines',


            ],
            'daily_checks' => [
                'url' => route('patient.daily_checks', [$patient->id]),
                'icon_class' => 'fas fa-user-check',
                'tooltip' => 'Denetimler',
                'required_permission' => 'daily_checks',
            ]
        ];

        $lastCheckDate = $patient->latestDailyCheck() ? Carbon::parse($patient->latestDailyCheck()->check_date)->format('d/m/Y H:i') : null;
        $vaccinesLast = $patient->vaccines()->orderBy('vaccination_date','desc')->first();

        return [
            'name' => (string)$patient->name,
            'tckn' => (int)$patient->tckn,
            'age' => (int)$patient->age,
            'gsm' => (string)$patient->gsm,
            'village' => [
                'name' => $patient->village->name ?? null
            ],
            'positive_or_contacted' => $patient->pcr_status ? 'P': ($patient->contacted_status ? 'T' : '-'),
            'patientStatus' => [
                'name' => $patient->patientStatus->name ?? null,
                'id' => $patient->patientStatus->id ?? null
            ],

            'dailyChecks' => [
                'check_date' => $lastCheckDate
            ],
            'vaccines' => [
                'last_vaccines_date' => $vaccinesLast->vaccination_date ?? null
            ],
            'quarantine_dates' => $patient->quarantine_dates,
            'action' => (string)$template = view()->make('adminlte::partials.btn_group', ['buttons' => $actionButtons])->render()
        ];
    }
}
