<?php
namespace App\Transformers;

use App\District;
use League\Fractal\TransformerAbstract;

class DistrictTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(District $district)
    {
        return [
            'id' => $district->id,
            'name' => $district->name
        ];
    }
}