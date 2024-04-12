<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectuser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Projectuser';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'user_id'];

    
}
