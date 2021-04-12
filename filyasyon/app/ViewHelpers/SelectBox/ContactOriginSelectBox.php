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
use Garavel\Base\ViewComponents\SelectBoxAbstract;
use Garavel\Base\ViewComponents\SelectBoxImplementation;
use Illuminate\Database\Eloquent\Collection;

class ContactOriginSelectBox extends SelectBoxAbstract implements SelectBoxImplementation {


    public $class = 'select2bs4';
    public $id = 'contact_origin_id';
    public $name = 'contact_origin_id';
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
        return ContactOrigin::orderBy('name', 'asc')
            ->cacheFor(now()->addDays(30))
            ->get();
    }


}
