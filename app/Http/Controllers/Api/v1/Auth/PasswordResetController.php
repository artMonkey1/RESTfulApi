<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PasswordResetController extends ApiController
{
    public function __construct()
    {
        //
    }

    /**
     * Create token password reset.
     *
     * @param PasswordRequest $request
     * @return JsonResponse
     */
    public function create(PasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->errorResponse('We can\'t find a user with that e-mail address.', JsonResponse::HTTP_NOT_FOUND);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60),
            ]
        );

        if ($user && $passwordReset){
            $user->notify(new PasswordResetRequest($passwordReset->token));
        }

        return $this->showMessage('We have e-mailed your password reset link!');
    }

    /**
     * Find token password reset.
     *
     * @param $token
     * @return JsonResponse
     * @throws \Exception
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return $this->errorResponse('This password reset token is invalid', JsonResponse::HTTP_NOT_FOUND);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return $this->errorResponse('This password reset token is invalid', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->successResponse(['data' => $passwordReset], JsonResponse::HTTP_OK);
    }

    /**
     * Reset password.
     *
     * @param \App\Http\Requests\PasswordResetRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function reset(\App\Http\Requests\PasswordResetRequest $request)
    {
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
            return $this->errorResponse('This password reset token is invalid', JsonResponse::HTTP_NOT_FOUND);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return $this->errorResponse('We can\'t find a user with that e-mail address.', JsonResponse::HTTP_NOT_FOUND);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess());

        return $this->showOne($user);
    }
}
