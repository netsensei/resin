<?php

namespace Resin\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    protected $table = 'objects';

    protected $fillable = ['object_number', 'title', 'work_pid', 'http_status'];

    public $timestamps = false;

    public function artist()
    {
        return $this->belongsTo('Resin\Models\Artist', 'artist_id', 'artist_id');
    }

    public function documents()
    {
        return $this->hasMany('Resin\Models\Document', 'object_number', 'object_number');
    }

    public static function count()
    {
        return Object::all()->count();
    }

    public static function countHasNoWorkPid()
    {
        return DB::table('objects')->where('work_pid',"")->count();
    }

    public static function countHasWorkPid()
    {
        return DB::table('objects')->where('work_pid',"<>","")->count();
    }
}
