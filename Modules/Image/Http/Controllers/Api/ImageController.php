<?php

namespace Modules\Image\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Image\Helpers\UploadImages;
use Modules\Image\Http\Requests\ImageCreateApiRequest;
use Modules\Image\Http\Requests\ImageUpdateApiRequest;
use Modules\Image\Repositories\ImageRepository;
use Modules\Image\Transformers\ImageTransformer;

/**
 * Class ImageController
 * @package Modules\Image\Http\Controllers\Api
 */
class ImageController extends BaseApiController
{
    /**
     * ImageController constructor.
     * @param ImageRepository $repository
     */
    public function __construct(ImageRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, ImageTransformer::class, $request));
    }

    /**
     * @param ImageCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(ImageCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('files');
            $upload = UploadImages::uploadImages($file, 'files');
            $entity = $this->repository->create($upload);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, ImageTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }


    public function update($identifier, ImageUpdateApiRequest $request)
    {
        $entity = $this->repository->find($identifier);
        $storeValues = $request->only([]);
        DB::beginTransaction();
        try {
            $entity = $this->repository->update($storeValues, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, ImageTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
