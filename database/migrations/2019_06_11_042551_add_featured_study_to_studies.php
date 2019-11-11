<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedStudyToStudies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::defaultStringLength(1);
        Schema::table('studies', function($table) {
            $table->string('featured')->default(0);

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
         Schema::table('studies', function($table) {
            $table->dropColumn('featured');

            

            });
        }
        catch(\Exception $e){}


    }
}
