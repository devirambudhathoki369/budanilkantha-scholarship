<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();
        return view('dataentry.academicyear.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
        ]);

        AcademicYear::create($request->all());

        return redirect()->back()->with('success', 'शैक्षिक सत्र सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $academicYear = AcademicYear::find($id);

        if (!$academicYear || !verify_hash($academicYear, $hash)) {
            abort(404);
        }

        return view('dataentry.academicyear.edit', compact('academicYear'));
    }

    public function update(Request $request, $id, $hash)
    {
        $academicYear = AcademicYear::find($id);

        if (!$academicYear || !verify_hash($academicYear, $hash)) {
            abort(404);
        }

        $request->validate([
            'academic_year' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
        ]);

        $academicYear->update($request->all());

        return redirect()->route('academicyear.index')->with('success', 'शैक्षिक सत्र सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $academicYear = AcademicYear::find($id);

        if (!$academicYear || !verify_hash($academicYear, $hash)) {
            abort(404);
        }

        $academicYear->delete();

        return redirect()->back()->with('success', 'शैक्षिक सत्र सफलतापूर्वक हटाइएको छ।');
    }
}
