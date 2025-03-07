<?php

namespace App\Services\Frontend\User;

use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Requests\Frontend\UserPasswordUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Services\Common\ClearService;
use App\Services\Common\UploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

readonly class UserService
{
    /**
     * @param UploadService $uploadService
     * @param UserInterface $userRepository
     */
    public function __construct(
        private UploadService $uploadService,
        private UserInterface $userRepository
    )
    {
    }

    /**
     * @param ProfileUpdateRequest $request
     * @param User $user
     * @return void
     */
    public function updateProfile(ProfileUpdateRequest $request, User $user): void
    {
        if ($request->hasFile('photo')) {
            $this->setProfilePhoto($user, $request->file('photo'));
        }
        $this->userRepository->save($user, ['name' => $request->get('name') ?? $user->name]);
    }


    /**
     * @param UserPasswordUpdateRequest $request
     * @param User $user
     * @return void
     */
    public function updatePassword(UserPasswordUpdateRequest $request, User $user): void
    {
        $this->userRepository->save($user, ['password' => Hash::make($request->input('new_password'))]);
        Auth::logout();
        new ClearService()->clearUserSession();
    }


    /**
     * @param User $user
     * @param $photo
     * @return void
     */
    private function setProfilePhoto(User $user, $photo): void
    {
        $photoName = $this->uploadService->uploadPhoto($photo, 'public/profile');
        $this->userRepository->save($user, ['photo' => $photoName]);
    }

}
