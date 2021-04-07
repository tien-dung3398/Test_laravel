<?php

namespace Modules\Attribute\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Attribute\Http\Requests\AttributeCreateApiRequest;
use Modules\Attribute\Http\Requests\AttributeUpdateApiRequest;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Transformers\AttributeTransformer;

/**
 * Class AttributeController
 * @property AttributeRepository $repository
 * @package Modules\Attribute\Http\Controllers\Api
 */
class AttributeController extends BaseApiController
{
    /**
     * AttributeController constructor.
     * @param AttributeRepository $repository
     */
    public function __construct(AttributeRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->filter($request);
        return $this->responseSuccess($this->transform($data, AttributeTransformer::class, $request));
    }

    /**
     * @param AttributeCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(AttributeCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->input('attributes')) {
                foreach ($request->input('attributes') as $attribute) {
                    $entity = $this->repository->create($attribute);
                    if ($request->input('category_ids')) {
                        $categoryIds = $request->input('category_ids');
                        $entity->categories()->sync($categoryIds);
                    }
                }
            }
            DB::commit();
            return $this->responseSuccess([], 200, 'thêm thuộc tính thành công');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param AttributeUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, AttributeUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);

        $storeValues = $request->only(['name', 'description', 'group']);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            if ($request->input('category_ids')) {
                $categoryIds = $request->input('category_ids');
                $entity->categories()->sync($categoryIds );
            }

            DB::commit();
            return $this->responseSuccess($this->transform($entity, AttributeTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
