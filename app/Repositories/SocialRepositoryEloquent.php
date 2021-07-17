<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SocialRepository;
use App\Entities\Social;

/**
 * Class SocialRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SocialRepositoryEloquent extends BaseRepository implements SocialRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Social::class;
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
