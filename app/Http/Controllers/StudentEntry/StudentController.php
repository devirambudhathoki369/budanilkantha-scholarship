<?php

namespace App\Http\Controllers\StudentEntry;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolYear;
use App\Models\AarakshyaMain;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request, $school_year_id)
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

        // Count students by scholarship type
        $aarakshyanCount = Student::where('school_year_id', $school_year_id)
            ->where('scholarship_type', 'from_aarakshyan')
            ->count();

        $examCount = Student::where('school_year_id', $school_year_id)
            ->where('scholarship_type', 'from_exam')
            ->count();

        return view('studententries.student.index', compact(
            'schoolYear',
            'students',
            'aarakshyaMains',
            'aarakshyanCount',
            'examCount'
        ));
    }

    public function store(Request $request, $school_year_id)
    {
        $schoolYear = SchoolYear::findOrFail($school_year_id);

        $request->validate([
            'student_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'emis_no' => 'nullable|string|max:255',
            'scholarship_type' => 'required|in:from_aarakshyan,from_exam',
            'aarakshya_main_id' => 'required_if:scholarship_type,from_aarakshyan|nullable|exists:aarakshya_main,id',
            'school_type' => 'required_if:scholarship_type,from_exam|nullable|in:public,private',
            'gpa' => 'required_if:scholarship_type,from_exam|nullable|numeric|min:0|max:4',
            'entrance_exam_marks' => 'required_if:scholarship_type,from_exam|nullable|integer|min:0',
        ]);

        // Check aarakshyan limit
        if ($request->scholarship_type == 'from_aarakshyan') {
            $currentAarakshyanCount = Student::where('school_year_id', $school_year_id)
                ->where('scholarship_type', 'from_aarakshyan')
                ->count();

            if ($currentAarakshyanCount >= $schoolYear->scholarship_by_aarakshyan_no) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'आरक्षणबाट छात्रवृत्ति प्राप्त गर्ने विद्यार्थीको संख्या पूरा भइसकेको छ।');
            }
        }

        $data = $request->all();
        $data['school_id'] = $schoolYear->school_id;
        $data['academic_year_id'] = $schoolYear->academic_year_id;
        $data['school_year_id'] = $school_year_id;

        // Calculate marks for exam-based scholarship
        if ($request->scholarship_type == 'from_exam') {
            $school_type_marks = ($request->school_type == 'public') ? 20 : 0;

            // Calculate GPA marks
            $gpa = $request->gpa;
            if ($gpa == 4.0) {
                $gpa_marks = 20;
            } elseif ($gpa >= 3.6 && $gpa < 4.0) {
                $gpa_marks = 16;
            } elseif ($gpa >= 3.2 && $gpa < 3.6) {
                $gpa_marks = 12;
            } elseif ($gpa >= 2.8 && $gpa < 3.2) {
                $gpa_marks = 8;
            } elseif ($gpa >= 2.4 && $gpa < 2.8) {
                $gpa_marks = 6;
            } elseif ($gpa >= 2.0 && $gpa < 2.4) {
                $gpa_marks = 5;
            } else {
                $gpa_marks = 0;
            }

            // Convert entrance exam marks to max 60
            $entrance_exam_converted = ($request->entrance_exam_marks / 100) * 60;

            $data['total_marks'] = $school_type_marks + $gpa_marks + $entrance_exam_converted;
        } else {
            $data['school_type'] = null;
            $data['gpa'] = null;
            $data['entrance_exam_marks'] = null;
            $data['total_marks'] = null;
            $data['aarakshya_main_id'] = $request->aarakshya_main_id;
        }

        Student::create($data);

        // Recalculate ranks for exam-based students
        if ($request->scholarship_type == 'from_exam') {
            $this->recalculateRanks($school_year_id);
        }

        return redirect()->back()->with('success', 'विद्यार्थी सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $student = Student::find($id);

        if (!$student || !verify_hash($student, $hash)) {
            abort(404);
        }

        $schoolYear = SchoolYear::with(['school', 'academicYear'])->findOrFail($student->school_year_id);
        $aarakshyaMains = AarakshyaMain::all();

        return view('studententries.student.edit', compact('student', 'schoolYear', 'aarakshyaMains'));
    }

    public function update(Request $request, $id, $hash)
    {
        $student = Student::find($id);

        if (!$student || !verify_hash($student, $hash)) {
            abort(404);
        }

        $schoolYear = SchoolYear::findOrFail($student->school_year_id);

        $request->validate([
            'student_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'emis_no' => 'nullable|string|max:255',
            'scholarship_type' => 'required|in:from_aarakshyan,from_exam',
            'aarakshya_main_id' => 'required_if:scholarship_type,from_aarakshyan|nullable|exists:aarakshya_main,id',
            'school_type' => 'required_if:scholarship_type,from_exam|nullable|in:public,private',
            'gpa' => 'required_if:scholarship_type,from_exam|nullable|numeric|min:0|max:4',
            'entrance_exam_marks' => 'required_if:scholarship_type,from_exam|nullable|integer|min:0',
        ]);

        // Check aarakshyan limit (excluding current student)
        if ($request->scholarship_type == 'from_aarakshyan' && $student->scholarship_type != 'from_aarakshyan') {
            $currentAarakshyanCount = Student::where('school_year_id', $student->school_year_id)
                ->where('scholarship_type', 'from_aarakshyan')
                ->where('id', '!=', $student->id)
                ->count();

            if ($currentAarakshyanCount >= $schoolYear->scholarship_by_aarakshyan_no) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'आरक्षणबाट छात्रवृत्ति प्राप्त गर्ने विद्यार्थीको संख्या पूरा भइसकेको छ।');
            }
        }

        $data = $request->all();

        // Calculate marks for exam-based scholarship
        if ($request->scholarship_type == 'from_exam') {
            $school_type_marks = ($request->school_type == 'public') ? 20 : 0;

            // Calculate GPA marks
            $gpa = $request->gpa;
            if ($gpa == 4.0) {
                $gpa_marks = 20;
            } elseif ($gpa >= 3.6 && $gpa < 4.0) {
                $gpa_marks = 16;
            } elseif ($gpa >= 3.2 && $gpa < 3.6) {
                $gpa_marks = 12;
            } elseif ($gpa >= 2.8 && $gpa < 3.2) {
                $gpa_marks = 8;
            } elseif ($gpa >= 2.4 && $gpa < 2.8) {
                $gpa_marks = 6;
            } elseif ($gpa >= 2.0 && $gpa < 2.4) {
                $gpa_marks = 5;
            } else {
                $gpa_marks = 0;
            }

            // Convert entrance exam marks to max 60
            $entrance_exam_converted = ($request->entrance_exam_marks / 100) * 60;

            $data['total_marks'] = $school_type_marks + $gpa_marks + $entrance_exam_converted;
        } else {
            $data['school_type'] = null;
            $data['gpa'] = null;
            $data['entrance_exam_marks'] = null;
            $data['total_marks'] = null;
            $data['rank'] = null;
            $data['aarakshya_main_id'] = $request->aarakshya_main_id;
        }

        $student->update($data);

        // Recalculate ranks for exam-based students
        if ($request->scholarship_type == 'from_exam') {
            $this->recalculateRanks($student->school_year_id);
        }

        return redirect()->route('student.index', $student->school_year_id)->with('success', 'विद्यार्थी सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $student = Student::find($id);

        if (!$student || !verify_hash($student, $hash)) {
            abort(404);
        }

        $school_year_id = $student->school_year_id;
        $scholarship_type = $student->scholarship_type;

        $student->delete();

        // Recalculate ranks if it was an exam-based student
        if ($scholarship_type == 'from_exam') {
            $this->recalculateRanks($school_year_id);
        }

        return redirect()->route('student.index', $school_year_id)->with('success', 'विद्यार्थी सफलतापूर्वक हटाइएको छ।');
    }

    private function recalculateRanks($school_year_id)
    {
        $examStudents = Student::where('school_year_id', $school_year_id)
            ->where('scholarship_type', 'from_exam')
            ->orderBy('total_marks', 'desc')
            ->get();

        $rank = 1;
        foreach ($examStudents as $student) {
            $student->rank = $rank;
            $student->save();
            $rank++;
        }
    }
}
