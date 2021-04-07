<?php

namespace Modules\Asset\Repositories;

use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Modules\Asset\Entities\Asset;
use Modules\Attribute\Entities\Attribute;
use Modules\Image\Entities\Image;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Modules\Asset\Helpers\WriteLog;

/**
 * Class AssetRepository
 * @package Modules\Platform\User\Repositories
 */
class AssetRepository extends BaseRepository implements ContactInterface
{
    protected $wirteLog;


    /**
     * AssetRepository constructor.
     * @param Application $app
     * @param WriteLog $wirteLog
     */
    public function __construct(Application $app, WriteLog $wirteLog)
    {
        parent::__construct($app);
        $this->wirteLog = $wirteLog;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Asset::class;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return Asset
     * @throws ValidatorException
     *
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Asset
     * @throws ValidatorException
     *
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilter($request)
    {
        $query = Asset::query();
        if ($request->get('category_ids')) {
            $categoryIds = explode(',', $request->get('category_ids'));
            $query->whereHas('assetCategory', function ($sql) use ($categoryIds) {
                $sql->whereIn('category_id', $categoryIds);
            });
        }
        return $query->paginate(intval($request->get('per_page')));
    }

    /**
     * @param $model
     * @param $request
     * @param null $status
     */
    public function creatAsset($model, $request, $status = null)
    {
        $barcode = $request->input('barcode');
        $this->wirteLog->writeLogPost($model, $barcode, $status);

        // thêm category với asset
        if ($request->input('category_id')) {
            $category_id = $request->input('category_id');
            $model->assetCategory()->sync($category_id);

            //thêm attributes với asset
            if ($request->input('attributes')) {
                $attributes = $request->input('attributes');
                $this->createAssetAttributes($model, $attributes, $category_id);
            }
        }

        // thêm ảnh cho asset
        if ($request->input('asset_images_uploaded')) {
            $imageIds = $request->input('asset_images_uploaded');
            Image::query()->whereIn('id', $imageIds)
                ->update(['imageable_id' => $model->id,
                    'imageable_type' => Asset::class]);
        }
    }

    /**
     * @param Asset $model
     * @param $attributes
     * @param null $category_id
     * @param null $attributeIds
     */
    public function createAssetAttributes(Asset $model, $attributes, $category_id = null, $attributeIds = null)
    {
        $attributeIds = [];
        foreach ($attributes as $key => $attribute) {
            //tồn tại id attribute thì lưu vào bảng trung gian
            if (isset($attribute['id']) && $attribute['id'] > 0) {
                $attributeIds[] = $attribute['id'];
            } else {
                // không tồn tại id thì tạo mới thuộc tính
                $att = new  Attribute();
                $att->fill($attribute);
                $att->save();
                $attributeIds[] = $att->id;
                if ($category_id != null) {
                    $att->categories()->sync($category_id);
                }
            }
        }
        $model->assetAttributes()->sync($attributeIds);
    }

    /**
     * @param $getOriginalAsset
     * @param $getChangeAsset
     * @param $model
     */
    public function logAsset($getOriginalAsset, $getChangeAsset, $model)
    {
        $arr = [];
        if (count($getChangeAsset) > 0) {
            unset($getChangeAsset['updated_at'], $getChangeAsset['barcode']);

            $life = $model->lifeAsset()->create([
                'asset_id' => $model->id,
                'type' => 20,
                'created_by' => 1
            ]);

            foreach ($getChangeAsset as $key => $value) {
                $arr[] = [
                    'value_before' => $getOriginalAsset[$key],
                    'value_after' => $value,
                    'name_property' => $key,
                    'life_asset_id' => $life->id,
                    'type' => 10,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $life->lifeAssetRow()->insert($arr);
        };
    }

    /**
     * @param $asset_Id
     */
    public function destroyAsset($asset_Id)
    {
        $asset = Asset::query()->findOrFail($asset_Id);
        $asset->destroy($asset_Id);
    }
}
