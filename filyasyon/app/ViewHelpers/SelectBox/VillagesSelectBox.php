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

use App\Models\Village;
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class VillagesSelectBox extends SelectBoxAbstract implements SelectBoxImplementation {


    public $class = 'select2bs4';
    public $id = 'village_id';
    public $name = 'village_id';
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
        return Village::orderBy('name', 'asc')
            ->where('town_id', 1132) //Altıntaş
            ->cacheFor(now()->addDays(30))
            ->get();
    }


}
