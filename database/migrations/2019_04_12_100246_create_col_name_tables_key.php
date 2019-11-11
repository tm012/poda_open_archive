<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColNameTablesKey extends Migration
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
        Schema::create('col_names_key', function (Blueprint $table) {
            $table->increments('id');
            $table->string('col_name')->nullable($value = true);
            $table->string('col_no')->nullable($value = true);
            $table->string('row_no')->nullable($value = true);
            // $table->string('author_name')->nullable($value = true);
            // $table->string('created_date')->nullable($value = true);
            $table->integer('data_id')->nullable($value = true);
            $table->integer('number_col')->nullable($value = true);
            // $table->string('study_path')->nullable($value = true);
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
        Schema::dropIfExists('col_names_key');
    }
}
