<?php

namespace App\Models;

use Garavel\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Model;

class DailyCheck extends Model
{

    use FileQueryCacheable;

    public function groupByDateWithHours()
    {
        return $this->groupBy('check_date','desc');
    }

}
