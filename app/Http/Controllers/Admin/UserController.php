<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('school')->get();
        $schools = School::all();
        return view('admin.user.index', compact('users', 'schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'required|in:admin,office_user,school_user',
            'school_id' => 'required_if:usertype,school_user|nullable|exists:schools,id',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        // Set school_id to null if usertype is not school_user
        if ($request->usertype != 'school_user') {
            $data['school_id'] = null;
        }

        User::create($data);

        return redirect()->back()->with('success', 'प्रयोगकर्ता सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $schools = School::all();
        return view('admin.user.edit', compact('user', 'schools'));
    }

    public function update(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'usertype' => 'required|in:admin,office_user,school_user',
            'school_id' => 'required_if:usertype,school_user|nullable|exists:schools,id',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        // Set school_id to null if usertype is not school_user
        if ($request->usertype != 'school_user') {
            $data['school_id'] = null;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'प्रयोगकर्ता सफलतापूर्वक अपडेट गरिएको छ।');
    }

    public function delete($id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $user->delete();

        return redirect()->back()->with('success', 'प्रयोगकर्ता सफलतापूर्वक हटाइएको छ।');
    }
}
