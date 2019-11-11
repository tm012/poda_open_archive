<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileUploadQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('file_upload_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->nullable($value = true);
            $table->string('file_type')->nullable($value = true);
            $table->string('file_ext')->nullable($value = true);
            $table->string('uploading')->default(0);
            $table->string('uploading_done')->default(0);
            $table->string('study_id')->nullable($value = true);
            $table->string('file_name_with_ext')->nullable($value = true);
            $table->string('file_url')->nullable($value = true);
            $table->string('user_id')->nullable($value = true);
            $table->string('task_name')->nullable($value = true);

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
        Schema::dropIfExists('file_upload_queues');
    }
}
