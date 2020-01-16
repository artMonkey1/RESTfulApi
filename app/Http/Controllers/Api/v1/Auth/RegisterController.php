<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Notifications\SingupVerification;
use Illuminate\Http\JsonResponse;

class RegisterController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    public function singUp(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;
        $data['applicant'] = User::APPLICANT_USER;

        $user = User::create($data);

        $user->notify(new SingupVerification());

        return $this->showOne($user, JsonResponse::HTTP_CREATED);
    }
}
