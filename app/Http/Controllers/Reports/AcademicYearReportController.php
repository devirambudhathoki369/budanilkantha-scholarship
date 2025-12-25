<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class AcademicYearReportController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();
        $schools = null;
        $selectedAcademicYear = null;

        if ($request->filled('academic_year_id')) {
            $selectedAcademicYear = AcademicYear::find($request->academic_year_id);

            $schools = SchoolYear::where('academic_year_id', $request->academic_year_id)
                ->with(['school.ward'])
                ->get()
                ->map(function($schoolYear) {
                    $totalScholarships = Student::where('school_year_id', $schoolYear->id)->count();
                    $byExam = Student::where('school_year_id', $schoolYear->id)
                        ->where('scholarship_type', 'from_exam')
                        ->count();
                    $byAarakshyan = Student::where('school_year_id', $schoolYear->id)
                        ->where('scholarship_type', 'from_aarakshyan')
                        ->count();

                    $schoolYear->total_scholarships = $totalScholarships;
                    $schoolYear->by_exam = $byExam;
                    $schoolYear->by_aarakshyan = $byAarakshyan;

                    return $schoolYear;
                });
        }

        return view('reports.academic-year-reports.index', compact(
            'academicYears',
            'schools',
            'selectedAcademicYear'
        ));
    }

    public function schoolStudents(Request $request, $school_year_id)
    {
        $schoolYear = SchoolYear::with(['school', 'academicYear'])->findOrFail($school_year_id);

        $query = Student::where('school_year_id', $school_year_id)
            ->with(['aarakshyaMain']);

        // Apply filters
        if ($request->filled('scholarship_type')) {
            $query->where('scholarship_type', $request->scholarship_type);
        }

        if ($request->filled('aarakshya_main_id')) {
            $query->where('aarakshya_main_id', $request->aarakshya_main_id);
        }

        $students = $query->get();
        $aarakshyaMains = \App\Models\AarakshyaMain::all();

        return view('reports.academic-year-reports.students', compact(
            'schoolYear',
            'students',
            'aarakshyaMains'
        ));
    }
}
