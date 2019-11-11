<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::defaultStringLength(191);
        Schema::table('users', function($table) {
            $table->string('institution_name')->nullable($value = true);
            $table->string('designation')->nullable($value = true);
            $table->string('user_approval_status')->default(0);
            $table->string('phone_number')->nullable($value = true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        try{
         Schema::table('users', function($table) {
            $table->dropColumn('institution_name');
            $table->dropColumn('designation');
            $table->dropColumn('user_approval_status');
            $table->dropColumn('phone_number');
            

            });
        }
        catch(\Exception $e){}
    }
}
