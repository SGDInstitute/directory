<?php namespace SGDInstitute\Directory;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'SGDInstitute\Directory\Components\DirectoryList' => 'directoryList',
            'SGDInstitute\Directory\Components\DirectoryDetails' => 'directoryDetails',
            'SGDInstitute\Directory\Components\DirectoryContact' => 'directoryContact',
        ];
    }

    public function registerSettings()
    {
    }
}
