<?php

namespace App\Repositories;

use App\Entities\Branch;
use App\Entities\Company;
use App\Entities\Complaint;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CategoryRepository;
use App\Entities\Category;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ComplaintRepositoryEloquent extends BaseRepository implements ComplaintRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Complaint::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
