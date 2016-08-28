<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSgdinstituteDirectoryHuman extends Migration
{
    public function up()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->string('social_media')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->dropColumn('social_media');
            $table->increments('id')->unsigned()->change();
        });
    }
}
