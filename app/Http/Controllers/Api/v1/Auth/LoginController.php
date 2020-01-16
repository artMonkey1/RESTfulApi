<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class LoginController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $credentials['verified'] = 1;
        $credentials['deleted_at'] = null;

        if (!\Auth::attempt($credentials)) {
            return $this->errorResponse('Unauthorised', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = \Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return $this->successResponse([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ], JsonResponse::HTTP_OK);

    }
}
