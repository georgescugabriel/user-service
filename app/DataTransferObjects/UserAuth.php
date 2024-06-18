<?php

namespace App\DataTransferObjects;

class UserAuth extends AbstractDataTransferObjects
{
    public int     $id;
    public string  $first_name;
    public string  $last_name;
    public string  $username;
    public string  $password;
    public ?int    $business_id;
    public ?int    $file_id;
    public string  $email;
    public string  $phone;
    public ?string $email_verified_at;
    public int     $is_admin;
    public string  $created_at;
    public string  $updated_at;

    public static function fromModel (\App\Models\User $model) : UserAuth
    {
        return new static([
            'id'                => intval($model->id),
            'first_name'        => $model->first_name,
            'last_name'         => $model->last_name,
            'username'          => $model->username,
            'password'          => $model->password,
            'business_id'       => $model->business_id ? intval($model->business_id) : null,
            'file_id'           => $model->file_id ? intval($model->file_id) : null,
            'is_admin'          => intval($model->is_admin),
            'email'             => $model->email,
            'phone'             => $model->phone,
            'email_verified_at' => $model->email_verified_at ? date("Y-m-d H:i:s", strtotime($model->email_verified_at)) : null,
            'created_at'        => date("Y-m-d H:i:s", strtotime($model->created_at)),
            'updated_at'        => date("Y-m-d H:i:s", strtotime($model->updated_at)),
        ]);
    }
}
