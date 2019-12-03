<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Qrcode
 * @package App\Models
 * @version September 16, 2019, 3:11 pm UTC
 *
 * @property integer user_id
 * @property string company_name
 * @property string website
 * @property string product_name
 * @property string product_url
 * @property number amount
 * @property string callback_url
 * @property string qrcode_path
 * @property boolean status
 */
class Qrcode extends Model
{
    use SoftDeletes;

    public $table = 'qrcodes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'company_name',
        'website',
        'product_name',
        'product_url',
        'amount',
        'callback_url',
        'qrcode_path',
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
        'company_name' => 'string',
        'website' => 'string',
        'product_name' => 'string',
        'product_url' => 'string',
        'amount' => 'float',
        'callback_url' => 'string',
        'qrcode_path' => 'string',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'company_name' => 'required',
        'product_name' => 'required',
        'product_url' => 'required',
        'amount' => 'required',
        'callback_url' => 'required',
        //'qrcode_path' => 'required',
        'status' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    
}
