<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create( 'permissions', function ( Blueprint $table ) {
            $table -> id();
            $table -> string( 'permission' );
            $table -> foreignId( 'role_id' )->nullable()->constrained()
                  -> onUpdate( 'cascade' ) -> onDelete( 'cascade' );

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        } );

        $input = [
            [ 'role_id' => 1, 'permission' => 'admin.dashboard' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.index' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.create' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.store' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.edit' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.update' ],
            [ 'role_id' => 1, 'permission' => 'admin.roles.delete' ],

        ];
        Permission ::insert( $input );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists( 'permissions' );
    }
}
