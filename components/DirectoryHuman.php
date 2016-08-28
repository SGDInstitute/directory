<?php
namespace SGDInstitute\Directory\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use SGDInstitute\Directory\Models\Human;

class DirectoryHuman extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Directory Human',
            'description' => 'Displays a single humans.',
        ];
    }

    public function humans()
    {
        $humans = Human::with('headshot', 'group')->get();

        foreach ($humans as $index => &$human) {
            if (isset($human->headshot)) {
                $human->headshot->path = $human->headshot->getPath();
            }
        }

        return $humans;
    }

    public function defineProperties()
    {
        return [
            'noHumansMessage' => [
                'title'             => 'No Humans',
                'description'       => 'Message to display on page if no humans are found.',
                'type'              => 'string',
                'default'           => 'No humans found',
                'showExternalParam' => false,
            ],
            'humanPage'       => [
                'title'       => 'Human Page',
                'description' => 'The page that shows the human in more detail.',
                'type'        => 'dropdown',
                'default'     => 'human/:slug',
                'group'       => 'Links',
            ],
        ];
    }

    public function getHumanPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
}
