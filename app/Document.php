<?php

namespace Resin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = ['object_number', 'url', 'type', 'http_status'];

    public $timestamps = false;

    public $appends = ['glyphicon'];

    public function getGlyphiconAttribute()
    {
        return ($this->http_status == 200) ? "glyphicon-ok" : "glyphicon-remove";
    }

    public static function count()
    {
        return Document::all()->count();
    }

    public static function countMergableDocuments()
    {
        return DB::table('documents')
            ->join('objects', 'objects.object_number', '=', 'documents.object_number')
            ->count();
    }

    public static function countOrphanDocuments()
    {
        return DB::table('documents')
            ->leftJoin('objects', 'objects.object_number', '=', 'documents.object_number')
            ->whereNull('objects.object_number')
            ->count();
    }
}
