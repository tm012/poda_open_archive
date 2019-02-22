<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename')->nullable($value = true);
            $table->string('data_id')->nullable($value = true);
            $table->string('file_url')->nullable($value = true);
            $table->string('path')->nullable($value = true);
            $table->string('type')->nullable($value = true);
            $table->string('study_id')->nullable($value = true);
            $table->string('dateset_id')->nullable($value = true);
            $table->integer('user_id')->nullable($value = true);
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
        Schema::dropIfExists('file_uploads');
    }
}
