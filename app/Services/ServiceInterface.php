<?php

namespace App\Services;

interface ServiceInterface
{
    public function fetchAll ($request);

    public function fetchOne($key);

    public function fetchByParams(array $params);

    public function create($request);

    public function update($request, $key);

    public function delete($key);
}
