<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRatingViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        $data = ReviewRate::query()->select('review_rates.rateable_type','review_rates.rateable_id',\DB::raw('ROUND(SUM(review_rates.rate) / COUNT("review_rates.rateable_id"),2) as rate'),\DB::raw('COUNT("review_rates.rateable_id") as followers'))
//            ->groupBy('review_rates.rateable_type','review_rates.rateable_id')->toSql();
        DB::statement("
          CREATE VIEW rating AS
          (
            select `review_rates`.`rateable_type`, `review_rates`.`rateable_id`, ROUND(SUM(review_rates.rate) / COUNT(review_rates.rateable_id),2) as rate, COUNT(review_rates.rateable_id) as followers from `review_rates` group by `review_rates`.`rateable_type`, `review_rates`.`rateable_id`
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
