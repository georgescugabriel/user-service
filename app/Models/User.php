<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property integer $id                     Id
 * @property string  $first_name             First Name
 * @property string  $last_name              Last Name
 * @property string  $username               Username
 * @property string  $password               Password
 * @property integer $business_id            Business ID
 * @property integer $file_id                File ID
 * @property integer $is_admin               Is Admin
 * @property string  $email                  Email
 * @property string  $phone                  Phone
 * @property integer $email_verified_at      Email Verified At
 * @property integer $created_at             Created At
 * @property integer $updated_at             Updated At
 * @property integer $deleted_at             Deleted At
 *
 */
class User extends AbstractModel
    implements MainModelInterface, AuthenticatableContract, CanResetPasswordContract, JWTSubject
{
    use SoftDeletes, HasFactory;
    use AuthenticatableTrait, CanResetPassword;

    protected $all_columns = [
        'id', 'first_name', 'last_name', 'username', 'password', 'business_id', 'file_id', 'is_admin', 'email', 'phone', 'email_verified_at',
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $fillable    = ['first_name', 'last_name', 'username', 'password', 'business_id', 'file_id', 'is_admin', 'email', 'phone', 'email_verified_at'];
    protected $hidden      = [
        'deleted_at'
    ];

    public function getJWTIdentifier ()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims ()
    {
        return [];
    }
}
