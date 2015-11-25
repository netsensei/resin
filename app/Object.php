<?php

namespace Resin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    protected $table = 'objects';

    protected $fillable = ['object_number', 'title', 'work_pid'];

    public $timestamps = false;

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
