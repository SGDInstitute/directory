<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSgdinstituteDirectoryHuman2 extends Migration
{
    public function up()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->integer('group_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->dropColumn('group_id');
        });
    }
}
