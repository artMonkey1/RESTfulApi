<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Models\User;
use App\Notifications\SingupVerification;
use Illuminate\Http\JsonResponse;

class ConfirmEmailController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only('resend');
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('The account has been succesfully');
    }

    public function resend(User $user)
    {
        if($user->isVerified()){
            $this->errorResponse('The user is already verified', JsonResponse::HTTP_CONFLICT);
        }

        $user->notify(new SingupVerification());

        return $this->showMessage('The verification email has been resend');
    }
}
