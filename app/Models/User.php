<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Client ID: 1
*Client Secret: rcemPIeCKuOHixsXtB3YTqJQO5EHIcsZlFwLQzaF
*Password grant client created successfully.
*Client ID: 2
*Client Secret: MThqxmxVKELcMkUQpr2wH771b8CsWHaYGraTLNb8
 */

/**
 * Class User
 * @package App\Models
 * @version September 16, 2019, 3:23 pm UTC
 *
 * @property string name
 * @property integer role_id
 * @property string email
 * @property string password
 * @property string remember_token
 */
class User extends Model
{
    use SoftDeletes, HasApiTokens, Notifiable;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'role_id',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'role_id' => 'integer',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'role_id' => 'required',
        'email' => 'required',
        // 'password' => 'required'
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function qrcodes()
    {
        return $this->hasMany('App\Models\Qrcode');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    //Get account associated with a user
    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }

    //Get account historires associated with a user
    public function account_histories()
    {
        return $this->hasMany('App\Models\AccountHostory');
    }

    
}
