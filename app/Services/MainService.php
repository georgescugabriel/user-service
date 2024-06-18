<?php

namespace App\Services;

use App\Repositories\MainRepository;

class MainService extends AbstractService
    implements MainServiceInterface
{
    public function __construct (MainRepository $repository)
    {
        $this->repository = $repository;
    }
}
