<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSgdinstituteDirectoryHuman5 extends Migration
{
    public function up()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->renameColumn('postition', 'position');
        });
    }
    
    public function down()
    {
        Schema::table('sgdinstitute_directory_human', function($table)
        {
            $table->renameColumn('position', 'postition');
        });
    }
}
