<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectuser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projectusers';

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
    protected $fillable = ['role','project_id', 'user_id'];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
