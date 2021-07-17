<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SettingRepository;
use App\Entities\Setting;

/**
 * Class SettingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }


    public function updateall($attributes = [])
    {
        if($attributes != null && count($attributes) > 0){
            foreach ($attributes as $key => $attribute){
                $setting = $this->model->firstOrCreate(['key'=>$key]);
                $setting['value'] = $attribute;
                $setting->save();
            }
        }

    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
