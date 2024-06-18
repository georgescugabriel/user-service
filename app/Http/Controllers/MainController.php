<?php

namespace App\Http\Controllers;

use App\Services\MainService;

class MainController extends Controller
{
    protected MainService $service;

    public function __construct (MainService $service)
    {
        $this->service = $service;
    }

    protected function validateRequest ($request, $update = false) : array
    {
        if ($update) {
            return $this->validate($request, [
                'first_name'        => 'string',
                'last_name'         => 'string',
                'username'          => 'string',
                'password'          => 'string',
                'business_id'       => 'nullable|integer',
                'file_id'           => 'nullable|integer',
                'email'             => 'string',
                'phone'             => 'string',
                'email_verified_at' => 'nullable|integer',
            ]);
        } else {
            return $this->validate($request, [
                'first_name'        => 'required|string',
                'last_name'         => 'required|string',
                'username'          => 'required|string|unique:users',
                'password'          => 'required|string',
                'business_id'       => 'nullable|integer',
                'file_id'           => 'nullable|integer',
                'email'             => 'required|string',
                'phone'             => 'required|string',
                'email_verified_at' => 'nullable|integer',
            ]);
        }
    }
}
