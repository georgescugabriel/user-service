<?php

namespace App\Classes;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QueryBuilder
{
    private AbstractModel $model;

    private int $limit = 25;
    private string $order_by = "id";
    private string $order = "DESC";
    private int $page = 1;

    /**
     * QueryBuilder constructor.
     *
     * @param $model
     */
    public function __construct ($model)
    {
        $this->model = $model;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        if($limit == -1) {
            $limit = PHP_INT_MAX;
        }
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param string $order_by
     */
    public function setOrderBy(string $order_by): void
    {
        $this->order_by = $order_by;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    private function offset(): int
    {
        return ($this->page * $this->limit) - $this->limit;
    }

    /**
     * @return Builder
     */
    public function newQuery () : Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array []
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($criteria);
        return [
            'count' => $query->count(),
            'items' => $query->firstOrFail()
        ];
    }

    /**
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getByCriteria(array $criteria, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($criteria);

        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getAll(array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param array $ids
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getByIds(array $ids, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->whereIn('id', $ids);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param array $ids
     * @param string $in_column
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getByColumnInWithCriteria(array $ids, string $in_column, array $criteria, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->whereIn($in_column, $ids)
            ->where($criteria);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }
    /**
     * @param array $ids
     * @param string $in_column
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getByColumnIn(array $ids, string $in_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->whereIn($in_column, $ids);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param array $dates
     * @param string $where_column
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getBetweenDates(array $dates, string $where_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->whereBetween($where_column, $dates);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param string $value
     * @param string $where_column
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getGreaterEqualThan(string $value, string $where_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($where_column, ">=", $value);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param string $value
     * @param string $where_column
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getGreaterThan(string $value, string $where_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($where_column, ">", $value);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param string $value
     * @param string $where_column
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getLessEqualThan(string $value, string $where_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($where_column, "<=", $value);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }

    /**
     * @param string $value
     * @param string $where_column
     * @param array|string[] $columns
     * @param array $relations
     *
     * @return array
     */
    public function getLessThan(string $value, string $where_column, array $columns = ['*'], array $relations = []): array
    {
        $query = $this->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($where_column, "<", $value);
        return [
            'count' => $query->count(),
            'items' => $query->orderBy($this->order_by, $this->order)
                ->offset($this->offset())
                ->limit($this->limit)
                ->get()
        ];
    }
}