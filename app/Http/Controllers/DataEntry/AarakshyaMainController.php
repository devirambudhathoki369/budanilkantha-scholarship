<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\AarakshyaMain;
use Illuminate\Http\Request;

class AarakshyaMainController extends Controller
{
    public function index()
    {
        $aarakshyaMains = AarakshyaMain::all();
        return view('dataentry.aarakshyamain.index', compact('aarakshyaMains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'percentage' => 'required|string|max:255',
        ]);

        AarakshyaMain::create($request->all());

        return redirect()->back()->with('success', 'आरक्षण सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $aarakshyaMain = AarakshyaMain::find($id);

        if (!$aarakshyaMain || !verify_hash($aarakshyaMain, $hash)) {
            abort(404);
        }

        return view('dataentry.aarakshyamain.edit', compact('aarakshyaMain'));
    }

    public function update(Request $request, $id, $hash)
    {
        $aarakshyaMain = AarakshyaMain::find($id);

        if (!$aarakshyaMain || !verify_hash($aarakshyaMain, $hash)) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'percentage' => 'required|string|max:255',
        ]);

        $aarakshyaMain->update($request->all());

        return redirect()->route('aarakshyamain.index')->with('success', 'आरक्षण सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $aarakshyaMain = AarakshyaMain::find($id);

        if (!$aarakshyaMain || !verify_hash($aarakshyaMain, $hash)) {
            abort(404);
        }

        $aarakshyaMain->delete();

        return redirect()->back()->with('success', 'आरक्षण सफलतापूर्वक हटाइएको छ।');
    }
}
