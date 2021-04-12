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
use App\Models\RelationshipToMainCase;
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class RelationshipToMainCaseSelectBox extends SelectBoxAbstract implements SelectBoxImplementation {


    public $class = 'select2bs4';
    public $id = 'relationship_to_main_case_id';
    public $name = 'relationship_to_main_case_id';
    public $isMultiple = false;
    public $constructMap = [
        'value' => 'id',
        'text'  => 'name'
    ];

    /**
     * @return Collection
     */
    public function getData() : Collection
    {
        return RelationshipToMainCase::orderBy('name', 'asc')
            ->cacheFor(now()->addDays(30))
            ->get();
    }


}
