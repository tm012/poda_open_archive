<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class AddLastUrlUpdate extends Migration
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
        Schema::table('file_uploads', function($table) {
            $date = Carbon::now();
            $table->date('last_update_url')->default($date->format("Y-m-d"));
            

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
         Schema::table('file_uploads', function($table) {
            $table->dropColumn('last_update_url');

            

            });
        }
        catch(\Exception $e){}
    }
}
