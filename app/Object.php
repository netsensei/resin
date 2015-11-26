<?php

namespace Resin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    protected $table = 'objects';

    protected $fillable = ['object_number', 'title', 'work_pid', 'http_status'];

    public $timestamps = false;

    public $appends = ['glyphicon'];

    public function getGlyphiconAttribute()
    {
        return ($this->http_status == 200) ? "glyphicon-ok" : "glyphicon-remove";
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
