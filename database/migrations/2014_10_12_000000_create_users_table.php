<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->default('/default.png');
            $table->string('email');
            $table->integer('wallet')->default(0);
            $table->tinyInteger('commission_status')->default(0);
            $table->double('income')->nullable()->default(0);
            $table->double('balance')->nullable()->default(0);
            $table->integer('commission')->nullable()->default(0);
            $table->string('phone');
            $table->string('replace_phone')->nullable();
            $table->unique(['phone','email','deleted_at']);
            $table->string('v_code')->nullable();
            $table->string('password');
            $table->string('lang')->default('ar');
            $table->boolean('active')->default(0)->comment('mobile activation');
            $table->boolean('banned')->default(0);
            $table->boolean('accepted')->default(1)->comment('Admin approval');
            $table->boolean('notify')->default(1);
            $table->boolean('online')->default(0);
            $table->unsignedInteger('role_id')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->enum('user_type',['admin','client','operation','company','technician','accountant'])->default('admin');

            $table->text('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->foreignId('company_id')->nullable()->constrained('users');
        });
//        الخصم من الموظف
        Schema::create('user_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->double('balance')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
        $user = new \App\Models\User();
        $user->name = 'المدير العام';
        $user->email      = 'info@aait.sa';
        $user->password   = '123456';
        $user->phone      = '01007416947';
        $user->address    = 'السعوديه - الرياض';
        $user->lang       = 'ar';
        $user->role_id  = 1;
        $user->user_type  = 'admin';
        $user->active     = 1;
        $user->banned    = 0;
        $user->save();
        $user = new \App\Models\User();
        $user->name = 'المدير العام';
        $user->email      = 'admin@example.net';
        $user->password   = '123456';
        $user->phone      = '01007416948';
        $user->address    = 'السعوديه - الرياض';
        $user->lang       = 'ar';
        $user->role_id  = 1;
        $user->user_type  = 'admin';
        $user->active     = 1;
        $user->banned    = 0;
        $user->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
