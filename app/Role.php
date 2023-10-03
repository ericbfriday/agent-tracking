<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Authorization\AuthorizationRoleTrait;

class Role extends Model
{
    use AuthorizationRoleTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}