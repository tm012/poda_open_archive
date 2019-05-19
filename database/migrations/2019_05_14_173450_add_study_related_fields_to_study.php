<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudyRelatedFieldsToStudy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::defaultStringLength(500);
        Schema::table('studies', function($table) {
            $table->string('study_description')->nullable($value = true);
            $table->string('study_licence')->nullable($value = true);
            $table->string('authors')->nullable($value = true);
            $table->string('publication_name')->nullable($value = true);
            $table->string('publication_time')->nullable($value = true);
            $table->string('contact_info')->nullable($value = true);
            $table->string('search_tags')->nullable($value = true);
            $table->string('archived_status')->default(0);
            
            $table->string('admin_approved')->default(0);
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
            $table->dropColumn('study_description');
            $table->dropColumn('study_licence');
            $table->dropColumn('authors');
            $table->dropColumn('publication_name');
            $table->dropColumn('publication_time');
            $table->dropColumn('contact_info');
            $table->dropColumn('search_tags');
            $table->dropColumn('admin_approved');
            $table->dropColumn('archived_status');

        });
         }
        catch(\Exception $e){}
    }
}
