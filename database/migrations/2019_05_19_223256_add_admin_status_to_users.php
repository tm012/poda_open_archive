<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminStatusToUsers extends Migration
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
            
            $table->string('admin_status')->default(0);
            

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
            $table->dropColumn('admin_status');

            

            });
        }
        catch(\Exception $e){}

    }
}
