<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCitiesTable.
 */
class CreateCompaniesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table) {
            $table->id();
            $table->string('manager_name')->nullable();
            $table->string('id_number')->nullable()->comment('رقم البطاقه');
            $table->string('commercial_num')->nullable();
            $table->string('acc_bank')->nullable()->comment('حساب بنكي');
            $table->string('commercial_image')->nullable()->comment('سجل الشركه التجاري');
            $table->string('tax_certificate')->nullable()->comment('الشهاده الضريبيه');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
		Schema::drop('cities');
	}
}
