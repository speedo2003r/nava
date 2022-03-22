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
            $table->double('vat_per', 9, 2)->default(0);
            $table->double('vat_amount', 9, 2)->default(0);

            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->string('coupon_num')->nullable();
            $table->double('coupon_amount', 9, 2)->default(0);

            $table->enum('payment_method', ['balance', 'cod']);
            $table->enum('pay_type', [ 'cash', 'visa','master','apple','stc'])->nullable();
            $table->enum('pay_status', ['pending', 'done'])->default('pending');
            $table->json('pay_data')->nullable();
            $table->enum('type',['service','parts'])->nullable();
            $table->tinyInteger('status')->nullable();
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
