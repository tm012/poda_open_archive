<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('datasets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('study_id')->nullable($value = true);
            $table->string('dateset_id')->nullable($value = true);
            $table->integer('user_id')->nullable($value = true);
            $table->string('dataset_name')->nullable($value = true);
            $table->string('task_related')->nullable($value = true);
            $table->string('created_date')->nullable($value = true);
            $table->text('dateset_path')->nullable($value = true);
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
        Schema::dropIfExists('datasets');
    }
}
