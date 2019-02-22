<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('studies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('study_id')->nullable($value = true);
            $table->string('study_name')->nullable($value = true);
            $table->string('access_status')->nullable($value = true);
            // $table->string('author_name')->nullable($value = true);
            $table->string('created_date')->nullable($value = true);
            $table->integer('user_id')->nullable($value = true);
             $table->string('study_path')->nullable($value = true);
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
        Schema::dropIfExists('studies');
    }
}
