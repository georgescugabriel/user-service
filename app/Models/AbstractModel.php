<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AbstractModel extends Model
{
    protected $all_columns;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function fetchByParams (array $params)
    {
        $model = $this::where('1', '1');
        foreach ($params as $column => $value) {
            if ( !in_array($column, $this->all_columns)) {
                throw new ModelNotFoundException('Column sent not exist in database');
            }
            $model->where($column, $value);
        }
        return $model->get();
    }
}
