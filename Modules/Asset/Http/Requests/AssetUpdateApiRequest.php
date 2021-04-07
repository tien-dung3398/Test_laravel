<?php

namespace Modules\Asset\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Asset API Request
 *
 * Class AssetCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AssetUpdateApiRequest extends ApiBaseRequest
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
