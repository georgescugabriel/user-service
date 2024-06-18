<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * @param  array  $request
     *
     * @return array
     */
    public function fetchAll (array $request) : array;

    /**
     * @param $id
     *
     */
    public function fetchById ($id);

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function fetchByParams (array $params) : array;

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function fetchByCode (array $params);

    /**
     * @param $request
     *
     * @return mixed
     */
    public function create ($request);

    /**
     * @param $request
     * @param $key
     *
     * @return mixed
     */
    public function update ($request, $key);

    /**
     * @param $key
     *
     * @return bool
     */
    public function delete ($key) : bool;

    /**
     * @return int
     */
    public function getTotal() : int;

    /**
     * @return int
     */
    public function getPages() : int;
}
