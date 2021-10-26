<?php namespace Codecycler\Passport\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Token Model
 */
class Token extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string table associated with the model
     */
    public $table = 'oauth_access_tokens';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = [];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scopes' => 'array',
        'revoked' => 'bool',
    ];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'expires_at',
        'created_at',
        'updated_at',
        'last_used',
    ];

    public $belongsTo = [
        'user' => [
            User::class,
            'key' => 'user_id',
        ],
    ];
}
