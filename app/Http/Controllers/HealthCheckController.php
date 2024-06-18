<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class HealthCheckController extends BaseController
{
    public function health ()
    {
        return response()->json([
            'status' => 'ok'
        ], Response::HTTP_OK);
    }

    public function info ()
    {
        $info['ms-name'] = env('APP_NAME', 'Anonymous');
        $info['memory_usage'] = memory_get_usage(true);
        $info['cpu_usage'] = sys_getloadavg()[0];
        return response()->json($info, Response::HTTP_OK);
    }
}