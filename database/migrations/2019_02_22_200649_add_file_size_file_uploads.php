<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileSizeFileUploads extends Migration
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
            $table->float('file_size')->default(0);
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
            $table->dropColumn('file_size');
        });
         }
        catch(\Exception $e){}
    }
}
