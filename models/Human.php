<?php namespace SGDInstitute\Directory\Models;

use Model;

/**
 * Model
 */
class Human extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sgdinstitute_directory_human';

    public $attachOne = [
        'headshot' => 'System\Models\File',
    ];

    public $belongsTo = [
        'group' => 'SGDInstitute\Directory\Models\Group',
    ];
}
