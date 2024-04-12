<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
    protected $fillable = ['title', 'content', 'status', 'user_id', 'user_id_do', 'project_id', 'type'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function user_do()
    {
        return $this->belongsTo('App\Models\User', 'user_id_do', 'id');
    }
    
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    
}
