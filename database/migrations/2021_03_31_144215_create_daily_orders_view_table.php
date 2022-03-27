<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDailyOrdersViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        $orderCount = DB::table('orders')->select(DB::raw('COUNT(*) as orderCount'),DB::raw('SUM((orders.final_total + orders.vat_amount) - orders.coupon_amount) + IFNULL(SUM(order_bills.price + order_bills.vat_amount),0) as total'),DB::raw('DATE(orders.created_at) as date'))
//            ->leftJoin('order_bills','order_bills.order_id','=','orders.id')
//            ->where('live',1)
//            ->groupBy('date')
//            ->get();
        DB::statement("
          CREATE VIEW daily_orders AS
          (
            select COUNT(*) as orderCount, SUM((orders.final_total + orders.vat_amount) - orders.coupon_amount) + IFNULL(SUM(order_bills.price + order_bills.vat_amount),0) as total, DATE(orders.created_date) as date from `orders` left join `order_bills` on `order_bills`.`order_id` = `orders`.`id` where `live` = 1 group by `date`
          )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating');
    }
}
