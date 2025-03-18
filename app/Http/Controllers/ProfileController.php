<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller 
{  public function index(Request $request)
    {
        $pageTitle = 'Hi ARSALAN ';
        return view('profile' , compact('pageTitle'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
