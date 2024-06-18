<?php

namespace App\Services;

use App\Models\MainModelInterface;
use App\Repositories\RepositoryInterface;

abstract class AbstractService
    implements ServiceInterface
{
    /** @var RepositoryInterface */
    protected RepositoryInterface $repository;

    public function fetchAll ($request) : array
    {
        return $this->repository->fetchAll($request);
    }

    public function fetchOne ($key)
    {
        if (is_numeric($key)) {
            return $this->repository->fetchById($key);
        } else {
            return $this->repository->fetchByCode([MainModelInterface::SEARCH_UNIQUE_KEY => $key]);
        }
    }

    public function getTotal () : int
    {
        return $this->repository->getTotal();
    }

    public function getPages () : int
    {
        return $this->repository->getPages();
    }

    public function fetchByParams (array $params) : array
    {
        return $this->repository->fetchByParams($params);
    }

    public function create ($request)
    {
        return $this->repository->create($request);
    }

    public function update ($request, $key)
    {
        return $this->repository->update($request, $key);
    }

    public function delete ($key) : bool
    {
        return $this->repository->delete($key);
    }
}
