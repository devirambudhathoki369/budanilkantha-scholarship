<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Ward;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('ward')->get();
        $wards = Ward::all();
        return view('dataentry.school.index', compact('schools', 'wards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'emis_no' => 'nullable|string|max:255',
            'school_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'ward_id' => 'required|exists:wards,id',
            'school_type' => 'required|in:public,private',
        ]);

        School::create($request->all());

        return redirect()->back()->with('success', 'विद्यालय सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $school = School::find($id);

        if (!$school || !verify_hash($school, $hash)) {
            abort(404);
        }

        $wards = Ward::all();
        return view('dataentry.school.edit', compact('school', 'wards'));
    }

    public function update(Request $request, $id, $hash)
    {
        $school = School::find($id);

        if (!$school || !verify_hash($school, $hash)) {
            abort(404);
        }

        $request->validate([
            'emis_no' => 'nullable|string|max:255',
            'school_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'ward_id' => 'required|exists:wards,id',
            'school_type' => 'required|in:public,private',
        ]);

        $school->update($request->all());

        return redirect()->route('school.index')->with('success', 'विद्यालय सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $school = School::find($id);

        if (!$school || !verify_hash($school, $hash)) {
            abort(404);
        }

        $school->delete();

        return redirect()->back()->with('success', 'विद्यालय सफलतापूर्वक हटाइएको छ।');
    }
}
