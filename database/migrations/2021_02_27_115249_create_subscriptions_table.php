<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('region_id')->constrained('regions');
            $table->foreignId('branch_id')->constrained('branches');
            $table->string('map_desc');
            $table->string('lat');
            $table->string('lng');
            $table->time('time');
            $table->date('date');
            $table->string('type');
            $table->string('cycle')->nullable()->default(0);
            $table->text('notes')->nullable()->default(null);
            $table->double('price',8,2);
            $table->enum('payment_method', ['balance', 'cod']);
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->string('coupon_num')->nullable();
            $table->string('coupon_type')->nullable();
            $table->double('coupon_amount', 9, 2)->default(0);
            $table->date('ended_at')->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('subscriptions');
    }
}
