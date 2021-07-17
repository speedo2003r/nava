<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContactUsRepository;
use App\Entities\ContactUs;

/**
 * Class ContactUsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContactUsRepositoryEloquent extends BaseRepository implements ContactUsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactUs::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
