<?php

namespace App\Repositories;

use App\Models\AccountHistory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AccountHistoryRepository
 * @package App\Repositories
 * @version September 20, 2019, 12:40 pm UTC
 *
 * @method AccountHistory findWithoutFail($id, $columns = ['*'])
 * @method AccountHistory find($id, $columns = ['*'])
 * @method AccountHistory first($columns = ['*'])
*/
class AccountHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'account_id',
        'user_id',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AccountHistory::class;
    }
}
