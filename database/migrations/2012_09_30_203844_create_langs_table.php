<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create( 'langs', function ( Blueprint $table ) {
            $table -> id();
            $table -> string( 'name');
            $table -> string( 'lang');
            $table -> softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        } );


        \App\Entities\Lang ::create( [ 'name' =>  'العربيه' ,'lang' => 'ar' ] );
        \App\Entities\Lang ::create( [ 'name' =>  'english' ,'lang' => 'en' ] );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists( 'roles' );
    }
}
