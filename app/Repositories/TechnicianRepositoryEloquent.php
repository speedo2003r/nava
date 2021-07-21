<?php

namespace App\Repositories;

use App\Entities\Technician;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TechnicianRepositoryEloquent extends BaseRepository implements TechnicianRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Technician::class;
    }

    public function find($id,$columns = ['*'])
    {
        $model = $this->model->find($id, $columns);
        return $this->parserResult($model);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
