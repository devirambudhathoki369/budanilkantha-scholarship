<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $users = User::all();
        $offices = Office::all();
        return view('dataentry.user.index', compact('users', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'office_id' => 'required|exists:offices,id',
            'usertype' => 'required|in:1,2',
            'fullname' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'email' => $request->email,
            'office_id' => $request->office_id,
            'usertype' => (int)$request->usertype,
            'fullname' => $request->fullname,
            'password' => $request->password,
        ]);

        return redirect()->back()->with('success', 'प्रयोगकर्ता सफलतापूर्वक थपिएको छ।');
    }

    public function edit($id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $offices = Office::all();
        return view('dataentry.user.edit', compact('user', 'offices'));
    }

    public function update(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'office_id' => 'required|exists:offices,id',
            'usertype' => 'required|in:1,2',
            'fullname' => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
            'office_id' => $request->office_id,
            'usertype' => (int)$request->usertype,
            'fullname' => $request->fullname,
        ]);

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

    public function changePasswordForm($id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        return view('dataentry.user.change-password', compact('user'));
    }

    public function changePassword(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'पुरानो पासवर्ड सही छैन।']);
        }

        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->back()->with('success', 'पासवर्ड सफलतापूर्वक परिवर्तन गरिएको छ।');
    }

    public function resetPassword($id, $hash)
    {
        $user = User::find($id);

        if (!$user || !verify_hash($user, $hash)) {
            abort(404);
        }

        $newPassword = Str::random(8);

        $user->update([
            'password' => $newPassword,
        ]);

        return redirect()->back()->with('success', 'पासवर्ड रिसेट गरिएको छ। नयाँ पासवर्ड: ' . $newPassword);
    }
}
