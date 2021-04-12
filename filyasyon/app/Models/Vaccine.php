<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $dates = ['vaccination_date'];


    public function setVaccinationDateAttribute($date)
    {
        $this->attributes['vaccination_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public function getVaccinationDateAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}
