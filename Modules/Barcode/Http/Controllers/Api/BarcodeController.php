<?php

namespace Modules\Barcode\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Barcode\Entities\Barcode;
use Modules\Barcode\Entities\BarcodeRow;
use Modules\Barcode\Http\Requests\BarcodeCreateApiRequest;
use Modules\Barcode\Http\Requests\BarcodeUpdateApiRequest;
use Modules\Barcode\Http\Requests\SetBarcodeRequets;
use Modules\Barcode\Repositories\BarcodeRepository;
use Modules\Barcode\Transformers\BarcodeRowsTransformer;
use Modules\Barcode\Transformers\BarcodeTransformer;
use PhpParser\Node\Stmt\Return_;


/**
 * Class BarcodeController
 * @property BarcodeRepository $repository
 * @package Modules\Barcode\Http\Controllers\Api
 */
class BarcodeController extends BaseApiController
{
    /**
     * BarcodeController constructor.
     * @param BarcodeRepository $repository
     */
    public function __construct(BarcodeRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = (new BarcodeRow())->with('barcodes')
            ->orderBy('id', 'DESC')->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, BarcodeRowsTransformer::class, $request));
    }

    public function show($identifier, Request $request)
    {
        $entity = $this->repository->find($identifier);
        return $this->responseSuccess($this->transform($entity, BarcodeTransformer::class, $request));
    }

    /**
     * @param BarcodeCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(BarcodeCreateApiRequest $request)
    {
        $category_id = $request->input('category_id');
        $created_by = 1;
        $quantity = $request->input('quantity');

        DB::beginTransaction();
        try {
            $entity = (new BarcodeRow())->createBarcodeRows($category_id, $created_by, $quantity);
            $this->repository->createBarcodes($quantity, $entity->id);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, BarcodeRowsTransformer::class, $request));
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
    public function searchBarcodes(Request $request)
    {
        $barcode = $request->get('barcode');
        list($invalid, $barcode) = $this->repository->searchBarcodes($barcode);
        if ($invalid == false && $barcode == null) {
            return $this->responseErrors(400, 'Barcode không tồn tại');
        }

        return $this->responseSuccess($this->transform($barcode, BarcodeTransformer::class, $request));
    }

    /**
     * @param SetBarcodeRequets $request
     * @return JsonResponse
     * Gán mã vạch cho tài sản
     */
    public function setBarcodes(SetBarcodeRequets $request)
    {
        $barcode = $request->input('barcode');
        $asset_id = $request->input('asset_id');
        DB::beginTransaction();
        try {
            list($invalid, $barcode) = $this->repository->setBarcodes($barcode, $asset_id);
            if ($invalid == false) {
                return $this->responseErrors(400, 'Mã code không hợp lệ hoặc đã được gán tài sản');
            }
            DB::commit();
            return $this->responseSuccess($this->transform($barcode, BarcodeTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }


    }
}
