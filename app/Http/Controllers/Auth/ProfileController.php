<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Requests\Frontend\UserPasswordUpdateRequest;
use App\Models\User;
use App\Services\Frontend\User\ProfileService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    /**
     * @param ProfileService $profileService
     */
    public function __construct(private readonly ProfileService $profileService)
    {
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function profile(User $user): mixed
    {
        if (auth()->user()->id === $user->id) {
            return view('frontend.user.profile.index', compact('user'));
        }
        return redirect('/');
    }


    /**
     * @param ProfileUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateProfile(ProfileUpdateRequest $request, User $user)
    {
        try {
            $this->profileService->updateProfile($request, $user);
            $this->nativeAlertNotify(__('site.response.success'), __('site.response.changed_success'));
            return redirect()->back();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            $this->nativeAlertNotify(__('site.response.error'), __('site.response.changed_failed'));
            return redirect()->back();
        }
    }

    /**
     * @param UserPasswordUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updatePassword(UserPasswordUpdateRequest $request, User $user)
    {
        try {
            if (auth()->user()->id === $user->id) {
                $updatePassword = $this->profileService->updatePassword($request, $user);
                if (isset($updatePassword['oldPassFailed'])) {
                    $this->nativeAlertNotify(__('site.response.error'), __('site.user.old_password_incorrect'));
                } elseif (isset($updatePassword['confirmPassFailed'])) {
                    $this->nativeAlertNotify(__('site.response.error'), __('site.user.confirm_password_incorrect'));
                } else {
                    $this->nativeAlertNotify(__('site.response.success'), __('site.response.changed_success'));
                }
            }
            return redirect()->back();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            $this->nativeAlertNotify(__('site.response.error'), __('site.response.changed_failed'));
            return redirect()->back();
        }
    }
}
