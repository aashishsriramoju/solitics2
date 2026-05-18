<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'                => ['required', 'string', 'max:100'],
            'email'               => ['required', 'email', 'unique:users,email,' . $user->id],
            'preferred_language'  => ['nullable', 'in:en,hi,te'],
        ]);

        $user->update($data);
        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully!');
    }

    public function setLanguage(Request $request)
    {
        $request->validate(['lang' => ['required', 'in:en,hi,te']]);
        session(['locale' => $request->lang]);
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $request->lang]);
        }
        return back()->with('success', 'Language updated.');
    }
}
