<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * @package App\Models
 * @version September 16, 2019, 3:23 pm UTC
 *
 * @property integer user_id
 * @property integer qrcode_id
 * @property number amount
 * @property string payment_method
 * @property integer qrcode_owner_id
 * @property string message
 * @property string status
 */
class Transaction extends Model
{
    use SoftDeletes;

    public $table = 'transactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'qrcode_id',
        'amount',
        'payment_method',
        'qrcode_owner_id',
        'message',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'qrcode_id' => 'integer',
        'amount' => 'float',
        'payment_method' => 'string',
        'qrcode_owner_id' => 'integer',
        'message' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'qrcode_id' => 'required',
        'amount' => 'required',
        'payment_method' => 'required',
        'qrcode_owner_id' => 'required',
        'status' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function qrcode()
    {
        return $this->belongsTo('App\Models\QRcode');
    }

    
}
