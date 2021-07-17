<?php

namespace App\Repositories;

use App\Entities\Ad;
use App\Entities\OrderService;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BannerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderServiceRepositoryEloquent extends BaseRepository implements OrderServiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderService::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
