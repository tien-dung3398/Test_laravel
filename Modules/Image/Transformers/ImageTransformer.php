<?php

namespace Modules\Image\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Image\Entities\Image;

class ImageTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param Image $image
     * @return array
     */
    public function transform(Image $image)
    {
        return [
            'id' => $image->id,
            'url' => $image->url,
            'created_at' => $image->created_at,
            'updated_at' => $image->updated_at,
        ];
    }
}
