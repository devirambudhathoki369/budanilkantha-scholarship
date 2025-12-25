<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return view('dataentry.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string|max:255',
        ]);

        Classes::create($request->all());

        return redirect()->back()->with('success', 'कक्षा सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $class = Classes::find($id);

        if (!$class || !verify_hash($class, $hash)) {
            abort(404);
        }

        return view('dataentry.classes.edit', compact('class'));
    }

    public function update(Request $request, $id, $hash)
    {
        $class = Classes::find($id);

        if (!$class || !verify_hash($class, $hash)) {
            abort(404);
        }

        $request->validate([
            'class' => 'required|string|max:255',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'कक्षा सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $class = Classes::find($id);

        if (!$class || !verify_hash($class, $hash)) {
            abort(404);
        }

        $class->delete();

        return redirect()->back()->with('success', 'कक्षा सफलतापूर्वक हटाइएको छ।');
    }
}
