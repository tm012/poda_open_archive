<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNews extends Migration
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
        Schema::create('news', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('news_title')->nullable($value = true);
            $table->text('news_description')->nullable($value = true);
            $table->string('news_author')->nullable($value = true);
            $table->string('news_image_path_storage')->nullable($value = true);

            $table->timestamps();
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
        Schema::drop('news');
    }
}
