<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Api\v1\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->showMessage('Successfully logged out', JsonResponse::HTTP_OK);
    }
}
