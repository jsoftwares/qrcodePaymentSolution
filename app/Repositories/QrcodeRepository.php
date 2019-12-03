<?php

namespace App\Repositories;

use App\Models\Qrcode;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QrcodeRepository
 * @package App\Repositories
 * @version September 16, 2019, 3:11 pm UTC
 *
 * @method Qrcode findWithoutFail($id, $columns = ['*'])
 * @method Qrcode find($id, $columns = ['*'])
 * @method Qrcode first($columns = ['*'])
*/
class QrcodeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return Qrcode::class;
    }
}
