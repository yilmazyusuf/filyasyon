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

use App\Models\HealthPersonnelProfession;
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class HealthPersonnelProfessionSelectBox extends SelectBoxAbstract implements SelectBoxImplementation {


    public $class = 'select2bs4';
    public $id = 'health_personnel_profession_id';
    public $name = 'health_personnel_profession_id';
    public $isMultiple = false;
    public $constructMap = [
        'value' => 'id',
        'text'  => 'name'
    ];

    /**
     * @return Collection
     */
    public function getData()
    : Collection
    {
        return HealthPersonnelProfession::orderBy('name', 'asc')
            ->cacheFor(now()->addDays(30))
            ->get();
    }


}
