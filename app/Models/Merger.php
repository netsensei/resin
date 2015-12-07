<?php

namespace Resin\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Merger extends Model
{
    protected $table = 'mergers';

    protected $fillable = ['filename', 'documents', 'objects'];

    public $timestamps = true;
}
