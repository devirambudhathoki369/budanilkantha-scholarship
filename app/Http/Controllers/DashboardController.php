<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\AarakshyaMain;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user type
     */
    public function index()
    {
        // Get all academic years with statistics
        $academicYearsStats = AcademicYear::select('academic_years.*')
            ->withCount([
                'schoolYears as total_schools',
                'students as scholarship_awarded'
            ])
            ->with(['schoolYears' => function($query) {
                $query->select(DB::raw('academic_year_id, SUM(total_students) as total_students'))
                    ->groupBy('academic_year_id');
            }])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function($academicYear) {
                $academicYear->total_students = $academicYear->schoolYears->sum('total_students');
                return $academicYear;
            });

        // Get current academic year statistics
        $currentAcademicYear = AcademicYear::where('is_current', '1')->first();

        $currentYearStats = null;
        $scholarshipTypeStats = null;
        $aarakshyaStats = null;

        if ($currentAcademicYear) {
            // Total schools in current year
            $totalSchools = SchoolYear::where('academic_year_id', $currentAcademicYear->id)->count();

            // Total students in current year
            $totalStudents = SchoolYear::where('academic_year_id', $currentAcademicYear->id)
                ->sum('total_students');

            // Total scholarship awarded
            $scholarshipAwarded = Student::where('academic_year_id', $currentAcademicYear->id)->count();

            // Scholarship by type
            $scholarshipByAarakshyan = Student::where('academic_year_id', $currentAcademicYear->id)
                ->where('scholarship_type', 'from_aarakshyan')
                ->count();

            $scholarshipByExam = Student::where('academic_year_id', $currentAcademicYear->id)
                ->where('scholarship_type', 'from_exam')
                ->count();

            // Aarakshya statistics
            $aarakshyaStats = AarakshyaMain::select('aarakshya_main.*')
                ->withCount([
                    'students as student_count' => function($query) use ($currentAcademicYear) {
                        $query->where('academic_year_id', $currentAcademicYear->id);
                    }
                ])
                ->having('student_count', '>', 0)
                ->get();

            $currentYearStats = [
                'academic_year' => $currentAcademicYear,
                'total_schools' => $totalSchools,
                'total_students' => $totalStudents,
                'scholarship_awarded' => $scholarshipAwarded,
            ];

            $scholarshipTypeStats = [
                'from_aarakshyan' => $scholarshipByAarakshyan,
                'from_exam' => $scholarshipByExam,
            ];
        }

        return view('dashboard', compact(
            'academicYearsStats',
            'currentYearStats',
            'scholarshipTypeStats',
            'aarakshyaStats'
        ));
    }

    /**
     * Show schools for a specific academic year
     */
    public function academicYearSchools($academic_year_id)
    {
        $academicYear = AcademicYear::findOrFail($academic_year_id);

        $schools = SchoolYear::where('academic_year_id', $academic_year_id)
            ->with(['school.ward'])
            ->get();

        return view('dashboard.academic-year-schools', compact('academicYear', 'schools'));
    }

    /**
     * Show students for a specific school in academic year
     */
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
        $aarakshyaMains = AarakshyaMain::all();

        return view('dashboard.school-students', compact(
            'schoolYear',
            'students',
            'aarakshyaMains'
        ));
    }
}
