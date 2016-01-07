<?php

namespace Resin\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = ['name', 'date_birth', 'date_death'];

    protected $appends = ['objectCount'];

    public $timestamps = true;

    public function getObjectCountAttribute()
    {
        return $this->objects->count();
    }

    public function objects()
    {
        return $this->hasMany('Resin\Models\Object', 'artist_id', 'artist_id');
    }
}
