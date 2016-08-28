<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSgdinstituteDirectoryHuman3 extends Migration
{
    public function up()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->string('headshot')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->dropColumn('headshot');
        });
    }
}
