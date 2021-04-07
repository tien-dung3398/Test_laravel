<?php

namespace Modules\Asset\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Asset\Entities\Asset;
use Modules\Attribute\Transformers\AttributesCustomTranformer;
use Modules\Category\Transformers\CategoryCustomTranformer;
use Modules\Image\Transformers\ImageTransformer;

class AssetTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['category', 'attributes', 'images','lifeasset'];

    /**
     * @param Asset $asset
     * @return array
     */
    public function transform(Asset $asset)
    {
        return [
            'id' => $asset->id,
            'name' => $asset->name,
            'code' => $asset->code,
            'barcode' => $asset->barcode,
            'vendor' => $asset->vendor,
            'created_at' => $asset->created_at,
            'updated_at' => $asset->updated_at,
        ];
    }

    /**
     * @param Asset $asset
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeCategory(Asset $asset)
    {
        $category = $asset->assetCategory;
        return $category ? $this->collection($category, new CategoryCustomTranformer()) : null;
    }

    /**
     * @param Asset $asset
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeAttributes(Asset $asset)
    {
        $attributes = $asset->assetAttributes;
        return $attributes ? $this->collection($attributes, new AttributesCustomTranformer()) : null;
    }

    /**
     * @param Asset $asset
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeImages(Asset $asset)
    {
        $images = $asset->images;
        return $images ? $this->collection($images, new ImageTransformer()) : null;
    }

    /**
     * @param Asset $asset
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeLifeAsset(Asset $asset)
    {
        $log = $asset->life;
        return $log ? $this->collection($log, new LifeAssetTransformer()) : null;
    }
}
