<?php

namespace App\Services\Frontend\User;

use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Requests\Frontend\UserPasswordUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{

    /**
     * @param ProfileUpdateRequest $request
     * @param User $user
     * @return void
     */
    public function updateProfile(ProfileUpdateRequest $request, User $user): void
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = md5(time() . rand(0, 1000)) . '.' . $photo->extension();
            $photo->storeAs('public/profile/', $photoName);
            $user->photo = $photoName;
            $user->save();
        }
        $user->name = $request->get('name') ?? $user->name;
        $user->save();
    }



    public function updatePassword(UserPasswordUpdateRequest $request, User $user): array
    {
        $response = [];

        if (!Hash::check($request->input('old_password'), $user->password)) {
            $response['oldPassFailed'] = true;
            return $response;
        }

        if ($request->input('new_password') !== $request->input('confirm_password')) {
            $response['confirmPassFailed'] = true;
            return $response;
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $response;
    }
}
