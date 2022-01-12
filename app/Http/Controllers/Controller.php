<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('PRC'); // 中国时区

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    /**
     * api响应封装
     * 调用方式：
     * return $this->fail(503003);
     * return $this->Success($obj);
     */
    public function success($data = [])
    {
        return response()->json([
            'status' => true,
            'code' => 1,
            'message' => config('errorcode.code')[1],
            'data' => $data,
        ]);
    }

    public function fail($code, $data = [])
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'message' => config('errorcode.code')[(int)$code],
            'data' => $data,
        ]);
    }
}
