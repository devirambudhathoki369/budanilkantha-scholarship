<?php

namespace App\Http\Controllers\StudentEntry;

use App\Http\Controllers\Controller;
use App\Models\School;

class SchoolListController extends Controller
{
    public function index()
    {
        $schools = School::with('ward')->get();
        return view('studententries.schoollist.index', compact('schools'));
    }
}
