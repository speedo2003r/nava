<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateOrdersTable.
 */
class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->id();
            $table->string('order_num', 50);

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('cascade');

            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->onDelete('cascade');


            $table->integer('total_services')->default(0);
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->string('coupon_num')->nullable();
            $table->string('coupon_type')->nullable();
            $table->double('coupon_amount', 9, 2)->default(0);
            $table->double('vat_per', 9, 2)->default(0);
            $table->double('vat_amount', 9, 2)->default(0);
            $table->double('final_total', 9, 2)->default(0);

            $table->enum('status', ['created', 'accepted', 'on-way', 'arrived', 'in-progress', 'finished', 'canceled'])->default('created');
            $table->string('cycle')->nullable()->default(null);
            $table->text('cancellation_reason')->nullable()->default(null);
            $table->string('canceled_by')->nullable()->default(null);

            $table->enum('payment_method', ['balance', 'cod']);
            $table->enum('pay_type', [ 'cash', 'visa','master','apple','stc'])->nullable();
            $table->enum('pay_status', ['pending', 'done'])->default('pending');
            $table->json('pay_data')->nullable();

            $table->double('lat', 15, 8)->default(24.68773);
            $table->double('lng', 15, 8)->default(46.72185);
            $table->string('map_desc', 255)->default('الرياض');

            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->text('notes')->nullable();

            $table->integer('estimated_time')->default(0);
            $table->integer('progress_start')->default(0);
            $table->integer('progress_time')->default(0);
            $table->enum('progress_type', ['progress', 'finish'])->default('progress');

            $table->integer('live')->default(0);

            $table->boolean('user_delete')->default(0);
            $table->boolean('provider_delete')->default(0);
            $table->boolean('admin_delete')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
		});



        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('service_id')->nullable()->constrained('services');
            $table->integer('count')->default(1);
            $table->double('price',8,2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
        Schema::create('order_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('part_id')->nullable()->constrained('parts');
            $table->integer('count')->default(0);
            $table->double('price',8,2)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}
}
