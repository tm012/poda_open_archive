<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeToDatasets extends Migration
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
        Schema::table('datasets', function($table) {
            
            $table->text('file_size')->nullable($value = true);
            

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
         Schema::table('datasets', function($table) {
            $table->dropColumn('file_size');

            

            });
        }
        catch(\Exception $e){}
    }
}
