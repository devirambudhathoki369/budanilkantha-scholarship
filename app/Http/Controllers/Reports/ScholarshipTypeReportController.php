<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class ScholarshipTypeReportController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();
        $schools = null;
        $selectedAcademicYear = null;
        $selectedScholarshipType = null;

        if ($request->filled('academic_year_id') && $request->filled('scholarship_type')) {
            $selectedAcademicYear = AcademicYear::find($request->academic_year_id);
            $selectedScholarshipType = $request->scholarship_type;

            // Get all school_years for the selected academic year
            $schoolYears = SchoolYear::where('academic_year_id', $request->academic_year_id)
                ->with(['school.ward'])
                ->get();

            $schools = $schoolYears->map(function($schoolYear) use ($request) {
                $studentCount = Student::where('school_year_id', $schoolYear->id)
                    ->where('scholarship_type', $request->scholarship_type)
                    ->count();

                $schoolYear->scholarship_type_student_count = $studentCount;

                return $schoolYear;
            })->filter(function($schoolYear) {
                return $schoolYear->scholarship_type_student_count > 0;
            });
        }

        return view('reports.scholarship-type-reports.index', compact(
            'academicYears',
            'schools',
            'selectedAcademicYear',
            'selectedScholarshipType'
        ));
    }

    public function schoolStudents(Request $request, $school_year_id, $scholarship_type)
    {
        $schoolYear = SchoolYear::with(['school', 'academicYear'])->findOrFail($school_year_id);

        $query = Student::where('school_year_id', $school_year_id)
            ->where('scholarship_type', $scholarship_type)
            ->with(['aarakshyaMain']);

        // Apply additional filters
        if ($request->filled('aarakshya_main_id')) {
            $query->where('aarakshya_main_id', $request->aarakshya_main_id);
        }

        $students = $query->get();
        $aarakshyaMains = \App\Models\AarakshyaMain::all();

        return view('reports.scholarship-type-reports.students', compact(
            'schoolYear',
            'students',
            'aarakshyaMains',
            'scholarship_type'
        ));
    }
}
