<?php

namespace App\Repositories;

use App\Entities\Ad;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BannerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProviderRepositoryEloquent extends BaseRepository implements AdRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ad::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
