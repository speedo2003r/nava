<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SocialRepository.
 *
 * @package namespace App\Repositories;
 */
interface SocialRepository extends RepositoryInterface
{
    public function updateall($attributes = []);
}
