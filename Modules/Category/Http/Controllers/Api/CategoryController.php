<?php

namespace Modules\Category\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Asset\Transformers\AssetTransformer;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Transformers\AttributeTransformer;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryCreateApiRequest;
use Modules\Category\Http\Requests\CategoryUpdateApiRequest;
use Modules\Category\Http\Requests\ListAttributeRequest;
use Modules\Category\Http\Requests\SetAttributeRequest;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Transformers\CategoryTransformer;

/**
 * Class CategoryController
 * @property CategoryRepository $repository
 * @package Modules\Category\Http\Controllers\Api
 */
class CategoryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $filter = $request->get('search');
        $data = $this->repository->getCategories($filter);
        return $this->responseSuccess($this->transform($data, CategoryTransformer::class, $request));
    }

    /**
     * @param CategoryCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(CategoryCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only(['name', 'code']);
            $storeValues['slug'] = Str::slug($request->input('name'));
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, CategoryTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param CategoryUpdateApiRequest $request
     * @return JsonResponse
     *
     */
    public function update($identifier, CategoryUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only(['name', 'code']);
        $storeValues['slug'] = Str::slug($request->input('name'));

        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, CategoryTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $categoryId
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($categoryId, Request $request)
    {
        $category = Category::query()->findOrFail($categoryId);

        DB::beginTransaction();
        try {
            if ($category) {
                $category->delete();
            }
            DB::commit();
            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            Db::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $category_id
     * @param Request $request
     * @return JsonResponse
     */
    public function listAttributes($category_id, Request $request)
    {
        $categoryId = Category::query()->with('attributes')->findOrFail($category_id);
        return $this->responseSuccess($this->transform($categoryId, CategoryTransformer::class, $request));
    }

    /**
     * @param $category_id
     * @param $attribute_id
     * @return JsonResponse
     */
    public function destroyAttributes($category_id, $attribute_id)
    {
        DB::beginTransaction();
        try {
            $categoryId = Category::query()->with('attributes')->findOrFail($category_id);
            $att = $categoryId->attributes()->where('attribute_id', $attribute_id)->first();
            if (!$att) {
                return $this->responseErrors(400, 'Thuộc tính không tồn tại hoặc không thuộc danh mục này', []);
            }
            $categoryId->attributes()->detach($att);
            DB::commit();
            return $this->responseSuccess([], 200, 'Xóa thuộc tính thành công');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $category_id
     * @param SetAttributeRequest $request
     * @return JsonResponse
     */
    public function setAttributes($category_id, SetAttributeRequest $request)
    {
        $category = Category::query()->with('attributes')->findOrFail($category_id);
        $attributes = $request->input('attributes');
        DB::beginTransaction();
        try {
            $data = $this->repository->setAttributes($attributes, $category);
            DB::commit();
            return $this->responseSuccess($this->transform($data, CategoryTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAttributes()
    {
        function tinhtong($n)
        {
            if ($n == 1){ return $n; }
            return $n + tinhtong($n-1);
        }
        return tinhtong(100);
    }
}
