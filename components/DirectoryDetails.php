<?php namespace SGDInstitute\Directory\Components;

use Lang;
use Cms\Classes\ComponentBase;
use SGDInstitute\Directory\Classes\ComponentHelper;
use SystemException;

class DirectoryDetails extends ComponentBase
{
    /**
     * A model instance to display
     * @var \October\Rain\Database\Model
     */
    public $record = null;
    
    /**
     * Message to display if the record is not found.
     * @var string
     */
    public $notFoundMessage;
    
    /**
     * Model column to use as a record identifier for fetching the record from the database.
     * @var string
     */
    public $modelKeyColumn;
    
    /**
     * Identifier value to load the record from the database.
     * @var string
     */
    public $identifierValue;

    /**
     * Names of the Human model columns
     * @var array
     */
    public $columnNames = [
        'name',
        'bio',
        'position',
        'pronouns',
        'twitter',
        'group_id',
        'slug',
    ];

    public function componentDetails()
    {
        return [
            'name'        => 'Human Details',
            'description' => 'Displays record details for a human.'
        ];
    }

    //
    // Properties
    //

    public function defineProperties()
    {
        return [
            'identifierValue' => [
                'title'       => 'Identifier value',
                'description' => 'Identifier value to load the record from the database. Specify a fixed value or ar url parameter.',
                'type'        => 'string',
                'default'     => '{{ :id }}',
                'validation'  => [
                    'required' => [
                        'message' => Lang::get('rainlab.builder::lang.components.details_identifier_value_required')
                    ]
                ]
            ],
            'modelKeyColumn' => [
                'title'       => 'Key Column',
                'description' => 'What to use to get record from database.',
                'type'        => 'autocomplete',
                'default'     => 'id',
                'validation'  => [
                    'required' => [
                        'message' => Lang::get('rainlab.builder::lang.components.details_key_column_required')
                    ]
                ],
                'showExternalParam' => false
            ],
            'notFoundMessage' => [
                'title'       => 'Not found message',
                'description' => 'Message used to display if the record is not found.',
                'default'     => Lang::get('Record not found.'),
                'type'        => 'string',
                'showExternalParam' => false
            ]
        ];
    }

    public function getModelKeyColumnOptions()
    {
        return $this->columnNames;
    }

    //
    // Rendering and processing
    //

    public function onRun()
    {
        $this->prepareVars();

        $this->record = $this->page['record'] = $this->loadRecord();
        $this->page->title = $this->record->name;
    }

    protected function prepareVars()
    {
        $this->notFoundMessage = $this->page['notFoundMessage'] = Lang::get($this->property('notFoundMessage'));
        $this->modelKeyColumn = $this->page['modelKeyColumn'] = $this->property('modelKeyColumn');
        $this->identifierValue = $this->page['identifierValue'] = $this->property('identifierValue');

        if (!strlen($this->modelKeyColumn)) {
            throw new SystemException('The model key column name is not set.');
        }
    }

    protected function loadRecord()
    {
        if (!strlen($this->identifierValue)) {
            return;
        }

        $modelClassName = 'SGDInstitute\Directory\Models\Human';
        if (!strlen($modelClassName) || !class_exists($modelClassName)) {
            throw new SystemException('Invalid model class name');
        }

        $model = new $modelClassName();
        return $model->where($this->modelKeyColumn, '=', $this->identifierValue)->first();
    }
}
