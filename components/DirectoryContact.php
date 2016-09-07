<?php namespace SGDInstitute\Directory\Components;

use Lang;
use Cms\Classes\ComponentBase;
use SGDInstitute\Directory\Models\Human;
use SystemException;

class DirectoryContact extends ComponentBase
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
            'name'        => 'Human Contact',
            'description' => 'Displays contact details for a human.',
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
                'type'        => 'dropdown',
                'placeholder' => 'Select Human',
                'options'     => Human::lists('name', 'id'),
                'validation'  => [
                    'required' => [
                        'message' => 'Identifier value is required!',
                    ],
                ],
            ],
            'notFoundMessage' => [
                'title'             => 'Not found message',
                'description'       => 'Message used to display if the record is not found.',
                'default'           => Lang::get('Record not found.'),
                'type'              => 'string',
                'showExternalParam' => false,
            ],
        ];
    }

    //
    // Rendering and processing
    //

    public function onRun()
    {
        $this->prepareVars();

        $this->record = $this->page['record'] = $this->loadRecord();
    }

    protected function prepareVars()
    {
        $this->notFoundMessage = $this->page['notFoundMessage'] = Lang::get($this->property('notFoundMessage'));
        $this->identifierValue = $this->page['identifierValue'] = $this->property('identifierValue');
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
        return $model->where('id', '=', $this->identifierValue)->first();
    }
}
