<?php

namespace Resin\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function getPurge()
    {
        return view('database.purge');
    }

    public function postPurge()
    {
        DB::table('documents')->truncate();
        DB::table('objects')->truncate();
        DB::table('artists')->truncate();
        DB::table('mergers')->truncate();
        Session::flash('success', 'Database successfully purged.');
        return view('database.purge');
    }
}
