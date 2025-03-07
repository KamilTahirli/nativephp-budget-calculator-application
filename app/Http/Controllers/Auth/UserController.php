<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Requests\Frontend\UserPasswordUpdateRequest;
use App\Models\User;
use App\Services\Frontend\User\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
    }


    /**
     * @param User $user
     * @return mixed
     * @throws AuthorizationException
     */
    public function profile(User $user): mixed
    {
        $this->authorize('view', $user);
        return view('frontend.user.profile.index', compact('user'));
    }


    /**
     * @param ProfileUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateProfile(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        try {
            $this->authorize('update', $user);
            $this->userService->updateProfile($request, $user);
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
    public function updatePassword(UserPasswordUpdateRequest $request, User $user): RedirectResponse
    {
        try {
            $this->authorize('view', $user);
            $this->userService->updatePassword($request, $user);
            return redirect()->back();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            $this->nativeAlertNotify(__('site.response.error'), __('site.response.changed_failed'));
            return redirect()->back();
        }
    }
}
