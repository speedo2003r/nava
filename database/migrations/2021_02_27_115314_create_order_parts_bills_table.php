<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateSocialsTable.
 */
class CreateOrderPartsBillsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_parts_bills', function(Blueprint $table) {
            $table->id();
            $table->foreignId('order_bill_id')->constrained('order_bills');
            $table->foreignId('order_part_id')->constrained('order_parts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('socials');
	}
}
