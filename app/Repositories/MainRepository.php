<?php

namespace App\Repositories;

use App\Classes\QueryBuilder;
use App\DataTransferObjects\User as UserDto;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MainRepository
    implements MainInterface
{
    /** @var User */
    public User $model;
    public QueryBuilder  $query;
    private int $total = 0;

    /** @param  User  $model */
    public function __construct (User $model)
    {
        $this->model = $model;
        $this->query = new QueryBuilder($model);
        if(request()->has("page")) {
            $this->query->setPage(request('page'));
        }
        if(request()->has("limit")) {
            $this->query->setLimit(request('limit'));
        }
        if(request()->has("order")) {
            $this->query->setOrder(request('order'));
        }
        if(request()->has("order_by")) {
            $this->query->setOrderBy(strtoupper(request('order_by')));
        }
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return ceil($this->total/$this->query->getLimit());
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * Fetch all records
     *
     * @param $request
     *
     * @return User[]|Collection
     */
    public function fetchAll ($request) : array
    {
        $request = $this->cleanRequest($request);
        if (array_key_exists('id', $request)) {
            $ids = explode(',', $request['id']);
            $results = $this->query->getByIds($ids);
        } else {
            if (is_array($request) && !empty($request)) {
                $results = $this->query->getByCriteria($request);
            } else {
                $results = $this->query->getAll();
            }
        }
        $output = [];
        foreach ($results['items'] as $result) {
            $output[] = $this->output($result);
        }
        $this->total = $results['count'];
        return $output;
    }

    /**
     * Fetch records by id
     *
     * @param $id
     *
     * @return UserDto
     */
    public function fetchById ($id) : UserDto
    {
        $results = $this->query->findByCriteria(['id' => $id]);
        $this->total = $results['count'];
        return $this->output($results['items']);
    }

    /**
     * Fetch records by params
     *
     * @param  array  $params
     *
     * @return array
     */
    public function fetchByParams (array $params) : array
    {
        $params = $this->cleanRequest($params);
        if(array_key_exists('id', $params)){
            $results = $this->query->getByIds(explode(',', $params['id']));
        } else {
            $results = $this->query->getByCriteria($params);
        }
        $this->total = $results['count'];
        $output = [];
        foreach ($results['items'] as $result) {
            $output[] = $this->output($result);
        }
        return $output;
    }
    /**
     * @param  array  $params
     *
     * @return UserDto
     */
    public function fetchByCode (array $params) : UserDto
    {
        $params = $this->cleanRequest($params);
        $results = $this->query->findByCriteria($params);
        $this->total = $results['count'];
        return $this->output($results['items']);
    }

    /**
     * Create new record
     *
     * @param $request
     *
     * @return mixed
     */
    public function create ($request) : User
    {
        $request['password'] = \Illuminate\Support\Facades\Hash::make($request['password']);
        return $this->query->newQuery()->create($request);
    }

    /**
     * Update a current record
     *
     * @param $request
     * @param $model
     *
     * @return UserDto|false
     */
    public function update ($request, $model)
    {
        if(array_key_exists("business_id", $request)
            && $request['business_id'] == 0) {
            $request['business_id'] = null;
        }
        /** @var User $model */
        $result = $this->query->findByCriteria(['id' => $model]);
        $this->total = $result['count'];
        $model = $result['items'];
        $model->fill($request);
        if ($model->isClean()) {
            return false;
        }
        $model->save();
        return $this->output($model);
    }

    /**
     * Delete a specific record
     *
     * @param $model
     *
     * @return bool|mixed|null
     * @throws Exception
     */
    public function delete ($model) : bool
    {
        $result = $this->query->findByCriteria(['id' => $model]);
        $this->total = $result['count'];
        return $result['items']->delete();
    }

    private function cleanRequest(&$request){
        unset($request['limit']);
        unset($request['page']);
        unset($request['order']);
        unset($request['order_by']);
        return $request;
    }

    /**
     * @param  User|Model  $model
     *
     * @return UserDto
     */
    protected function output (User $model) : UserDto
    {
        return UserDto::fromModel($model);
    }
}
