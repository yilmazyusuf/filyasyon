<?php

namespace App\Models;

use Carbon\Carbon;
use Garavel\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    use FileQueryCacheable;

    protected static $flushCacheOnUpdate = true;

    protected $guarded = [];
    protected $dates = ['detection_date', 'ex_date', 'healing_date', 'quarantine_start_date', 'quarantine_end_date'];


    public function patientStatus()
    {
        return $this->belongsTo(PatientStatus::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function dailyChecks()
    {
        return $this->hasMany(DailyCheck::class);
    }

    public function latestDailyCheck()
    {
        return $this->dailyChecks()->orderBy('check_date', 'desc')->first();
    }

    public function isDailyCheckable() : bool
    {
        $checkBlockerPatientStatusses = [
            6, 7, 8
        ];
        return !in_array($this->patient_status_id, $checkBlockerPatientStatusses);
    }

    public function dailyCheckableBlockedMessage() : string
    {
        $checkBlockerPatientStatusses = [
            6 => 'Hastanin tedavisi hastanede devam ediyor.',
            7 => 'Hasta iyilesti.',
            8 => 'Hasta vefat etti.'
        ];
        return $checkBlockerPatientStatusses[$this->patient_status_id] ?? 'Hastaya denetim girilebilir.';
    }


    public function vaccines()
    {
        return $this->hasMany(Vaccine::class);
    }


    public function setDetectionDateAttribute($date)
    {
        if (is_null($date)) {
            return false;
        }
        $this->attributes['detection_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public function setExDateAttribute($date)
    {
        if (is_null($date)) {
            return false;
        }
        $this->attributes['ex_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public function setHealingDateAttribute($date)
    {
        if (is_null($date)) {
            return false;
        }
        $this->attributes['healing_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }


    public function setGsmAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        $re = '/^0\(([0-9]{3})\) ([0-9]{3}) ([0-9]{4})$/';
        preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0);

        if (count($matches) == 0) {
            return null;
        }

        $this->attributes['gsm'] = $matches[0][1] . $matches[0][2] . $matches[0][3];
    }

    public function getGsmAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        return '0(' . substr($value, 0, 3) . ')'
            . ' '
            . substr($value, 3, 3)
            . ' '
            . substr($value, 6, 4);
    }

    public function getDetectionDateAttribute($value)
    {
        return Carbon::createFromDate($value)->format('d/m/Y');
    }

    public function getQuarantineDatesAttribute()
    {

        return Carbon::parse($this->quarantine_start_date)->formatLocalized('%d %B') . ' - ' .
            Carbon::parse($this->quarantine_end_date)->formatLocalized('%d %B');
    }

    public function getExDateAttribute($value)
    {
        return Carbon::createFromDate($value)->format('d/m/Y');
    }

    public function getHealingDateAttribute($value)
    {
        return Carbon::createFromDate($value)->format('d/m/Y');
    }


    public function getQuarantinePeriodAttribute()
    {
        $startDate = Carbon::parse($this->quarantine_start_date);
        $endDate = Carbon::parse($this->quarantine_end_date);
        $periodDays = $endDate->diffInDays($startDate);

        return $periodDays;
    }


    public function getQuarantinePeriodToEndAttribute()
    {
        $startDate = Carbon::now();
        $endDate = Carbon::parse($this->quarantine_end_date)->addDays(1);
        return $startDate->diffInDays($endDate, false);
    }


    public function getQuarantinePeriodCurrentPercentAttribute()
    {
        $totalDays = $this->quarantinePeriod;
        $remainingDays = $this->quarantinePeriodToEnd;
        if ($remainingDays <= 0) {
            return 100;
        }

        return ($totalDays - $remainingDays) * 100 / $totalDays;
    }

    public function getIsQuarantineCompletedAttribute(): bool
    {
        $endDate = Carbon::parse($this->quarantine_end_date);
        return $endDate->lessThan(Carbon::now());
    }


    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserPatientsByVillage($query)
    {
        if (isset(auth()->user()->village)) {
            return $query->where('village_id', '=', auth()->user()->village->id);
        }

        return $query;
    }

    /**
     * Set the base cache tags that will be present
     * on all queries.
     *
     * @return array
     */
    protected function getCacheBaseTags(): array
    {
        return [
            'patient',
        ];
    }

    public function scopeDailyChechList()
    {
        return $this->dailyChecks()
            ->orderBy('check_date', 'desc')
            ->get();
    }

    public function scopeGroupDailyCheckByHour()
    {
        $checkLists = $this->dailyChechList();
        $dateLists = [];

        foreach ($checkLists as $checkList) {
            $checkedDate = Carbon::parse($checkList->check_date)->format('Y-m-d');
            $dateLists[$checkedDate][] = $checkList->check_date;

        }
        return $dateLists;
    }

    public function scopeTodaysChecks()
    {

        $today = date('Y-m-d');
        $todaysChecks = $this->dailyChecks()
            ->where('check_date', 'LIKE', '%' . $today . '%')
            ->orderBy('check_date', 'desc')
            ->get()
            ->toArray();

        return $todaysChecks;
    }


}
