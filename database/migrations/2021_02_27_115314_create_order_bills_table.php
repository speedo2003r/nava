<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateSocialsTable.
 */
class CreateOrderBillsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_bills', function(Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->longText('text')->nullable();
            $table->double('price',8,2)->nullable();
            $table->enum('type',['service','parts'])->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
