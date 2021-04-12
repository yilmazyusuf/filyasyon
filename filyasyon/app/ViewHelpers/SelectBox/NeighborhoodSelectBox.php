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

use App\Models\Neighborhood;
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class NeighborhoodSelectBox extends SelectBoxAbstract implements SelectBoxImplementation
{


    public $class = 'select2bs4';
    public $id = 'neighborhood_id';
    public $name = 'neighborhood_id';
    public $isMultiple = false;
    public $constructMap = [
        'value' => 'id',
        'text' => 'name'
    ];
    public $selectedValues = [];

    /**
     * @return Collection
     */
    public function getData(): Collection
    {

        $neighborhoods = Neighborhood::orderBy('name', 'asc');

        if (count($this->selectedValues) > 0) {
            $neighborhoods->whereIn('village_id', $this->selectedValues);
        }

        $neighborhoodsCollection = $neighborhoods->cacheFor(now()->addDays(30))->get();

        return $neighborhoodsCollection;
    }


}
