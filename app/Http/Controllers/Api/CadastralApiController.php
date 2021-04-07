<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\ResponseTrait;
use App\Province;

class CadastralApiController
{
    use ResponseTrait;
    public function index()
    {
        $provinces = Province::query()->with(['districts', 'districts.wards'])->get();
        return $this->responseSuccess($provinces);
    }
}
