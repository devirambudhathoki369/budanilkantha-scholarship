<?php

namespace App\Http\Controllers;

use App\Models\DemandTraining;
use App\Models\FiscalYear;
use App\Models\TrainingClass;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Show the dashboard based on user type
     */
    public function index()
    {
        return view('dashboard');
    }
}
