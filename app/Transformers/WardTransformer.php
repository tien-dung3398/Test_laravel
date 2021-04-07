<?php
namespace App\Transformers;

use App\Ward;
use League\Fractal\TransformerAbstract;

class WardTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(Ward $ward)
    {
        return [
            'id' => $ward->id,
            'name' => $ward->name
        ];
    }
}