<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use FontLib\Table\Type\name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserCreateApiRequest;
use Modules\User\Http\Requests\UserUpdateApiRequest;
use Modules\User\Repositories\UserRepository;
use Modules\User\Transformers\UserTransformer;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;


/**
 * Class UserController
 * @property UserRepository $repository
 * @package Modules\User\Http\Controllers\Api
 */
class UserController extends BaseApiController
{

}
