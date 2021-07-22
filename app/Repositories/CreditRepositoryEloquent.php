<?php

namespace App\Repositories;

use App\Entities\Credit;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CreditRepository;

/**
 * Class BankRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CreditRepositoryEloquent extends BaseRepository implements CreditRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Credit::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
