<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->simplePaginate(50);

        return view('activity_logs.index', [
            'activities' =>  $activities,
        ]);
    }
}
