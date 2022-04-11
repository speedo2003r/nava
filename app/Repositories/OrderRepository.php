<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    public function storeOrder($request);
    public function updateOrder($data,$request);
    public function orderProductStore($data, $request);
    public function addStatusTimeLine($order_id,$status);
    public function addBillStatusTimeLine($order_bill_id,$status);
}
