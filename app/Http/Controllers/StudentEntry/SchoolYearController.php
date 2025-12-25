<?php

namespace App\Http\Controllers\StudentEntry;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function index($school_id)
    {
        $school = School::findOrFail($school_id);
        $schoolYears = SchoolYear::where('school_id', $school_id)
            ->with(['academicYear', 'school'])
            ->get();
        $academicYears = AcademicYear::all();

        return view('studententries.schoolyear.index', compact('school', 'schoolYears', 'academicYears'));
    }

    public function store(Request $request, $school_id)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'total_students' => 'required|integer|min:1',
        ]);

        $total_students = $request->total_students;

        // Calculate scholarship_no based on total students
        if ($total_students < 500) {
            $scholarship_percentage = 10;
        } elseif ($total_students >= 500 && $total_students <= 800) {
            $scholarship_percentage = 12;
        } else {
            $scholarship_percentage = 15;
        }

        $scholarship_no = floor(($total_students * $scholarship_percentage) / 100);
        $scholarship_by_aarakshyan_no = floor(($scholarship_no * 45) / 100);
        $scholarship_by_exam_no = floor(($scholarship_no * 55) / 100);

        SchoolYear::create([
            'school_id' => $school_id,
            'academic_year_id' => $request->academic_year_id,
            'total_students' => $total_students,
            'scholarship_no' => $scholarship_no,
            'scholarship_by_aarakshyan_no' => $scholarship_by_aarakshyan_no,
            'scholarship_by_exam_no' => $scholarship_by_exam_no,
        ]);

        return redirect()->back()->with('success', 'शैक्षिक वर्ष सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $schoolYear = SchoolYear::find($id);

        if (!$schoolYear || !verify_hash($schoolYear, $hash)) {
            abort(404);
        }

        $school = School::findOrFail($schoolYear->school_id);
        $academicYears = AcademicYear::all();

        return view('studententries.schoolyear.edit', compact('schoolYear', 'school', 'academicYears'));
    }

    public function update(Request $request, $id, $hash)
    {
        $schoolYear = SchoolYear::find($id);

        if (!$schoolYear || !verify_hash($schoolYear, $hash)) {
            abort(404);
        }

        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'total_students' => 'required|integer|min:1',
        ]);

        $total_students = $request->total_students;

        // Calculate scholarship_no based on total students
        if ($total_students < 500) {
            $scholarship_percentage = 10;
        } elseif ($total_students >= 500 && $total_students <= 800) {
            $scholarship_percentage = 12;
        } else {
            $scholarship_percentage = 15;
        }

        $scholarship_no = floor(($total_students * $scholarship_percentage) / 100);
        $scholarship_by_aarakshyan_no = floor(($scholarship_no * 45) / 100);
        $scholarship_by_exam_no = floor(($scholarship_no * 55) / 100);

        $schoolYear->update([
            'academic_year_id' => $request->academic_year_id,
            'total_students' => $total_students,
            'scholarship_no' => $scholarship_no,
            'scholarship_by_aarakshyan_no' => $scholarship_by_aarakshyan_no,
            'scholarship_by_exam_no' => $scholarship_by_exam_no,
        ]);

        return redirect()->route('schoolyear.index', $schoolYear->school_id)->with('success', 'शैक्षिक वर्ष सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $schoolYear = SchoolYear::find($id);

        if (!$schoolYear || !verify_hash($schoolYear, $hash)) {
            abort(404);
        }

        $school_id = $schoolYear->school_id;
        $schoolYear->delete();

        return redirect()->route('schoolyear.index', $school_id)->with('success', 'शैक्षिक वर्ष सफलतापूर्वक हटाइएको छ।');
    }
}
