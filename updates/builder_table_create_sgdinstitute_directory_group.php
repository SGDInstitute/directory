<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSgdinstituteDirectoryGroup extends Migration
{
    public function up()
    {
        Schema::create('sgdinstitute_directory_group', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('key');
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sgdinstitute_directory_group');
    }
}
