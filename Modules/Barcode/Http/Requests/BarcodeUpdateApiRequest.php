<?php

namespace Modules\Barcode\Http\Requests;
use App\Http\Requests\ApiBaseRequest;

/**
 * Barcode API Request
 *
 * Class BarcodeCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class BarcodeUpdateApiRequest extends ApiBaseRequest
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
