<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\User\Repositories\UserRepository;
use Modules\User\Transformers\UserTransformer;



/**
 * Class UserController
 * @property UserRepository $repository
 * @package Modules\User\Http\Controllers\Api
 */
class UserController extends BaseApiController
{

    /**
     * UserController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        dd(1);
        DB::beginTransaction();
        try {
            $storeValues = $request->only(['name', 'email', 'password']);
            $storeValues['api_token'] = Str::random(80);
            $storeValues['expires_token'] = Carbon::now()->addMinute(15)->format('Y-m-d H:m:s');
            $entity = $this->repository->create($storeValues);
            DB::commit();
            return $this->responseSuccess($this->transform($entity, UserTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }
}
