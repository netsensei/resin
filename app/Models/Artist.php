<?php

namespace Resin\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = ['name', 'date_birth', 'date_death'];

    public $timestamps = true;
}
