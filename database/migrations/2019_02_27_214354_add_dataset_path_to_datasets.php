<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatasetPathToDatasets extends Migration
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
            $table->string('dataset_url')->nullable($value = true);
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
            $table->dropColumn('dataset_url');
        });
         }
        catch(\Exception $e){}
    }
}
