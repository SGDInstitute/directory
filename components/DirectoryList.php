<?php namespace SGDInstitute\Directory\Components;

use Lang;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use RainLab\Builder\Classes\ComponentHelper;
use SGDInstitute\Directory\Models\Human;
use SystemException;
use Exception;

class DirectoryList extends ComponentBase
{
    /**
     * A collection of records to display
     * @var \October\Rain\Database\Collection
     */
    public $records;

    /**
     * Message to display when there are no records.
     * @var string
     */
    public $noRecordsMessage;

    /**
     * Reference to the page name for linking to details.
     * @var string
     */
    public $detailsPage;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     * Model column name to display in the list.
     * @var string
     */
    public $displayColumn;

    /**
     * Model column to use as a record identifier in the details page links
     * @var string
     */
    public $detailsKeyColumn;

    /**
     * Name of the details page URL parameter which takes the record identifier.
     * @var string
     */
    public $detailsUrlParameter;

    public function componentDetails()
    {
        return [
            'name'        => 'Directory Record List',
            'description' => 'Displays a list of humans.',
        ];
    }

    //
    // Properties
    //

    public function defineProperties()
    {
        return [
            'noRecordsMessage'    => [
                'title'             => 'No records message',
                'description'       => 'Message to display if no humans are found.',
                'type'              => 'string',
                'default'           => 'No records found.',
                'showExternalParam' => false,
            ],
            'detailsPage'         => [
                'title'             => 'Details Page',
                'description'       => 'Page to display human details.',
                'type'              => 'dropdown',
                'showExternalParam' => false,
                'group'             => 'Link to the details page',
            ],
            'detailsKeyColumn'    => [
                'title'             => 'Details key column',
                'description'       => 'Model column to use as identifier.',
                'type'              => 'autocomplete',
                'depends'           => 'human',
                'showExternalParam' => false,
                'group'             => 'Link to the details page',
            ],
            'detailsUrlParameter' => [
                'title'             => 'URL parameter name',
                'description'       => 'Name of the details page URL parameter which takes the record identifier.',
                'type'              => 'string',
                'default'           => 'id',
                'showExternalParam' => false,
                'group'             => 'Link to the details page',
            ],
            'sortColumn'          => [
                'title'             => 'Sort by column',
                'description'       => 'Column the humans should be ordered by.',
                'type'              => 'autocomplete',
                'depends'           => 'human',
                'group'             => 'sorting',
                'showExternalParam' => false,
            ],
            'sortDirection'       => [
                'title'             => 'Sort Direction',
                'type'              => 'dropdown',
                'showExternalParam' => false,
                'group'             => 'sorting',
                'options'           => [
                    'asc'   => 'Ascending',
                    'desc'  => 'Descending'
                ],
            ],
        ];
    }

    public function getDetailsPageOptions()
    {
        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');

        $pages = [
                '-' => '-- no details page --',
            ] + $pages;

        return $pages;
    }

    public function getDisplayColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getDetailsKeyColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getSortColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    //
    // Rendering and processing
    //

    public function onRun()
    {
        $this->prepareVars();

        $this->records = $this->page['records'] = $this->listRecords();
    }

    protected function prepareVars()
    {
        $this->noRecordsMessage = $this->page['noRecordsMessage'] = Lang::get($this->property('noRecordsMessage'));
        $this->detailsKeyColumn = $this->page['detailsKeyColumn'] = $this->property('detailsKeyColumn');
        $this->detailsUrlParameter = $this->page['detailsUrlParameter'] = $this->property('detailsUrlParameter');

        $detailsPage = $this->property('detailsPage');
        if ($detailsPage == '-') {
            $detailsPage = null;
        }

        $this->detailsPage = $this->page['detailsPage'] = $detailsPage;

        if (strlen($this->detailsPage)) {
            if (!strlen($this->detailsKeyColumn)) {
                throw new SystemException('The details key column should be set to generate links to the details page.');
            }

            if (!strlen($this->detailsUrlParameter)) {
                throw new SystemException('The details page URL parameter name should be set to generate links to the details page.');
            }
        }
    }

    protected function listRecords()
    {
        $model = new Human();
        $model = $this->sort($model);
        return $model->get();
    }

    protected function sort($model)
    {
        $sortColumn = trim($this->property('sortColumn'));
        if (!strlen($sortColumn)) {
            return $model;
        }

        $sortDirection = trim($this->property('sortDirection'));

        if ($sortDirection !== 'desc') {
            $sortDirection = 'asc';
        }

        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->orderBy($sortColumn, $sortDirection);
    }
}
