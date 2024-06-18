<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function index () : \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $this->service->fetchAll(\request()->all()),
            'total' => $this->service->getTotal(),
            'pages' => $this->service->getPages()
        ], Response::HTTP_OK);
    }

    public function store (Request $request) : \Illuminate\Http\JsonResponse
    {
        $this->validateRequest($request);
        return response()->json(['data' => $this->service->create($request->all())], Response::HTTP_CREATED);
    }

    public function show ($key) : \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->service->fetchOne($key)], Response::HTTP_OK);
    }

    public function update (Request $request, $key) : \Illuminate\Http\JsonResponse
    {
        $this->validateRequest($request, true);
        $database_data = $this->service->update($request->all(), $key);
        if ($database_data) {
            return response()->json(['data' => $database_data], Response::HTTP_OK);
        } else {
            return response()->json(['error' => "At least one value must change"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy ($key) : \Illuminate\Http\JsonResponse
    {
        $this->service->delete($key);
        return response()->json(['data' => 'Deleted Successfully'], Response::HTTP_OK);
    }

    abstract protected function validateRequest ($request, $update = false);
}
