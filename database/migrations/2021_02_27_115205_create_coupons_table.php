<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        add new view table to show users and count of use of coupon
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['public','private']);
            $table->enum('kind',['percent','fixed'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->string('code')->nullable();
            $table->double('value',9,2)->nullable();
            $table->integer('max_use')->nullable();
            $table->integer('count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
