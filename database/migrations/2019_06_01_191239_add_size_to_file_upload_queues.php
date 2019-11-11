<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeToFileUploadQueues extends Migration
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
        Schema::table('file_upload_queues', function($table) {
            
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
         Schema::table('file_upload_queues', function($table) {
            $table->dropColumn('file_size');

            

            });
        }
        catch(\Exception $e){}
    }
}
