<?php

namespace App\Http\Transformers;

use App\Models\Patient;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract
{

    /**
     * @param HeadlineNews $headlineNews
     *
     * @return  array
     */
    public function transform(Patient $patient)
    {
        $lastCheckDate = $patient->latestDailyCheck() ? Carbon::parse($patient->latestDailyCheck()->check_date)->format('d/m/Y H:i') : null;
        $vaccinesLast = $patient->vaccines()->orderBy('vaccination_date', 'desc')->first();

        return [
            'patient_id'            => (string)$patient->id,
            'name'                  => (string)$patient->name,
            'tckn'                  => (int)$patient->tckn,
            'age'                   => (int)$patient->age,
            'gsm'                   => (string)$patient->gsm,
            'village'               => [
                'name' => $patient->village->name ?? null
            ],
            'neighborhood'               => [
                'name' => $patient->neighborhood->name ?? null
            ],
            'positive_or_contacted' => $patient->pcr_status ? 'P' : ($patient->contacted_status ? 'T' : '-'),
            'patientStatus'         => [
                'name' => $patient->patientStatus->name ?? null,
                'id'   => $patient->patientStatus->id ?? null
            ],

            'dailyChecks'      => [
                'check_date' => $lastCheckDate
            ],
            'vaccines'         => [
                'last_vaccines_date' => $vaccinesLast->vaccination_date ?? null
            ],
            'quarantine_dates' => $patient->quarantineDatesDmy
        ];
    }
}
