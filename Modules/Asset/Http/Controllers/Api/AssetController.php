<?php

namespace Modules\Asset\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Asset\Http\Requests\AssetCreateApiRequest;
use Modules\Asset\Http\Requests\AssetUpdateApiRequest;
use Modules\Asset\Repositories\ContactInterface;
use Modules\Asset\Repositories\AssetRepository;
use Modules\Asset\Transformers\AssetTransformer;


/**
 * Class AssetController
 * @property AssetRepository $repository
 * @package Modules\Asset\Http\Controllers\Api
 * @property  ContactInterface $interFace
 */
class AssetController extends BaseApiController
{

    protected $interFace;

    /**
     * AssetController constructor.
     * @param AssetRepository $repository
     * @param ContactInterface $interFace
     */
    public function __construct(AssetRepository $repository, ContactInterface $interFace)
    {
        parent::__construct($repository);
        $this->interFace = $interFace;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->interFace->getFilter($request);
        return $this->responseSuccess($this->transform($data, AssetTransformer::class, $request));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return JsonResponse
     */
    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, AssetTransformer::class, $request));
    }

    /**
     * @param AssetCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(AssetCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $storeValues = $request->only(['name', 'code', 'barcode']);
            $entity = $this->repository->create($storeValues);
            $this->repository->creatAsset($entity, $request);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, AssetTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param AssetUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, AssetUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $status = 'update';
        $storeValues = $request->only(['name', 'code', 'barcode']);

        DB::beginTransaction();
        try {
            $getOriginalAsset = $entity->getOriginal();
            $entity = $this->repository->update($storeValues, $entity->id);
            $getChangeAsset = $entity->getChanges();
            $this->repository->creatAsset($entity, $request, $status);
            $this->repository->logAsset($getOriginalAsset, $getChangeAsset, $entity);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, AssetTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $asset_Id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($asset_Id, Request $request)
    {
        $this->repository->destroyAsset($asset_Id);
        return $this->responseSuccess([], 200, 'Xóa tài sản thành công');
    }

}
