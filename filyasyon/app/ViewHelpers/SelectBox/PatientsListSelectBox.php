<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 13.01.2021
 */

namespace App\ViewHelpers\SelectBox;

use App\Models\Bt;
use App\Models\ContactOrigin;
use App\Models\Patient;
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class PatientsListSelectBox extends SelectBoxAbstract implements SelectBoxImplementation {


    public $class = 'select2bs4';
    public $id = 'contact_origin_patient_id';
    public $name = 'contact_origin_patient_id';
    public $isMultiple = false;
    public $constructMap = [
        'value' => 'id',
        'text'  => 'name'
    ];

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        return Patient::orderBy('name', 'asc')
            ->cacheFor(now()->addDays(30))
            ->get();
    }


}
