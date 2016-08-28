<?php namespace SGDInstitute\Directory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSgdinstituteDirectoryHuman extends Migration
{
    public function up()
    {
        Schema::create('sgdinstitute_directory_human', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('bio')->nullable();
            $table->string('postition')->nullable();
            $table->string('pronouns')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sgdinstitute_directory_human');
    }
}
