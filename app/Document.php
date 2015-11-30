<?php

namespace Resin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = ['object_number', 'url', 'type', 'http_status'];

    public $timestamps = false;

    public $appends = ['entity_type', 'format', 'enabled','representation_order', 'reference'];

    public function object()
    {
        return $this->belongsTo('Resin\Object', 'object_number', 'object_number');
    }

    public function getEntityTypeAttribute()
    {
        return "work";
    }

    public function getEnabledAttribute()
    {
        return "1";
    }

    public function getFormatAttribute()
    {
        return ($this->type == "Data") ? "html" : "";
    }

    public function getRepresentationOrderAttribute()
    {
        return ($this->type == "Representation") ? $this->order : "";
    }

    public function getReferenceAttribute()
    {
        if ($this->type == "Representation") {
            return ($this->order == "1") ? "1" : "0";
        }

        return NULL;
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
