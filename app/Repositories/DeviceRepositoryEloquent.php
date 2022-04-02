<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DeviceRepository;
use App\Entities\Device;

/**
 * Class DeviceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DeviceRepositoryEloquent extends BaseRepository implements DeviceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Device::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
