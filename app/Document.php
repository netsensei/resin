<?php

namespace Resin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = ['object_number', 'url', 'type'];

    public $timestamps = false;

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
