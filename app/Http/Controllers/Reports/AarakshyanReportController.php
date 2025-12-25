<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AarakshyaMain;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class AarakshyanReportController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();
        $aarakshyaMains = AarakshyaMain::all();
        $schools = null;
        $selectedAcademicYear = null;
        $selectedAarakshyaMain = null;

        if ($request->filled('academic_year_id') && $request->filled('aarakshya_main_id')) {
            $selectedAcademicYear = AcademicYear::find($request->academic_year_id);
            $selectedAarakshyaMain = AarakshyaMain::find($request->aarakshya_main_id);

            // Get all school_years for the selected academic year
            $schoolYears = SchoolYear::where('academic_year_id', $request->academic_year_id)
                ->with(['school.ward'])
                ->get();

            $schools = $schoolYears->map(function($schoolYear) use ($request) {
                $studentCount = Student::where('school_year_id', $schoolYear->id)
                    ->where('scholarship_type', 'from_aarakshyan')
                    ->where('aarakshya_main_id', $request->aarakshya_main_id)
                    ->count();

                $schoolYear->aarakshyan_student_count = $studentCount;

                return $schoolYear;
            })->filter(function($schoolYear) {
                return $schoolYear->aarakshyan_student_count > 0;
            });
        }

        return view('reports.aarakshyan-reports.index', compact(
            'academicYears',
            'aarakshyaMains',
            'schools',
            'selectedAcademicYear',
            'selectedAarakshyaMain'
        ));
    }

    public function schoolStudents($school_year_id, $aarakshya_main_id)
    {
        $schoolYear = SchoolYear::with(['school', 'academicYear'])->findOrFail($school_year_id);
        $aarakshyaMain = AarakshyaMain::findOrFail($aarakshya_main_id);

        $students = Student::where('school_year_id', $school_year_id)
            ->where('scholarship_type', 'from_aarakshyan')
            ->where('aarakshya_main_id', $aarakshya_main_id)
            ->with(['aarakshyaMain'])
            ->get();

        return view('reports.aarakshyan-reports.students', compact(
            'schoolYear',
            'aarakshyaMain',
            'students'
        ));
    }
}
