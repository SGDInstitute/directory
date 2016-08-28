<?php namespace SGDInstitute\Directory;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'SGDInstitute\Directory\Components\DirectoryList' => 'directorylist'
        ];
    }

    public function registerSettings()
    {
    }
}
