<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateSocialsTable.
 */
class CreateSocialsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('socials', function(Blueprint $table) {
            $table->id();
            $table->string('key', 50);
            $table->longText('value')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
		});
        $data = [
            ['key' => 'facebook', 'value' => 'https://www.facebook.com'],
            ['key' => 'twitter', 'value' => 'https://twitter.com'],
            ['key' => 'youtube', 'value' => 'https://www.youtube.com'],
            ['key' => 'linked', 'value' => 'https://www.linkedin.com'],
        ];

        DB::table('socials')->insert($data);
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
