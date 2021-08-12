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

        DB::statement("
          CREATE VIEW rating AS
          (
            select `review_rates`.`rateable_type`, `review_rates`.`rateable_id`, `review_rates`.`rate`, COUNT('review_rates.rateable_id') as followers from `users` left join `review_rates` on `review_rates`.`rateable_id` = `users`.`id` WHERE `review_rates`.`rateable_type` = 'App\\\Entities\\\User' and `users`.`deleted_at` is null group by `review_rates`.`rateable_type`, `review_rates`.`rateable_id`, `review_rates`.`rate`
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
