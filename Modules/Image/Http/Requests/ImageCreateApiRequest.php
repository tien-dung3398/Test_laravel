<?php

namespace Modules\Image\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Image API Request
 *
 * Class ImageCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class ImageCreateApiRequest extends ApiBaseRequest
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
