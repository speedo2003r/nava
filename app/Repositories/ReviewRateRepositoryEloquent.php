<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ReviewRateRepository;
use App\Entities\ReviewRate;

/**
 * Class ReviewRateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReviewRateRepositoryEloquent extends BaseRepository implements ReviewRateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReviewRate::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
