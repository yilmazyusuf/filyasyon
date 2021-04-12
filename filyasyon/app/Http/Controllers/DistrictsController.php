<?php

namespace App\Http\Controllers;

use App\ViewHelpers\SelectBox\NeighborhoodSelectBox;
use Illuminate\Http\JsonResponse;

class DistrictsController extends Controller
{
    public function neighborhoodsByVillage($villageId): JsonResponse
    {

        $neighborhoodSelectBox = new NeighborhoodSelectBox();
        $neighborhoodSelectBox->selectedValues = [$villageId];

        return response()
            ->json(
                [
                    'neighborhoods' => viewHelper($neighborhoodSelectBox)->render()
                ]
            );

    }
}
