<?php

namespace Modules\User\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * User API Request
 *
 * Class UserCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class UserUpdateApiRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
