<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\v1\CompanyResource;
use App\Models\User;
use App\Http\Controllers\Api\v1\ApiController;
use App\Notifications\EmailChanged;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'.CompanyResource::class)->only(['store', 'update']);

        $this->middleware('any.scope:manage-account')->except(['index']);

        $this->middleware('can:manage-account,user')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function index()
    {
        $this->allowedAdminAction();

        $users = User::paginate();

        return $this->showCollection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email')){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->name = $request->email;
        }

        if($request->has('password')){
            $user->name = bcrypt($request->password);
        }

        if($request->has('applicant')){
            $user->applicant = $request->applicant;
        }

        if($request->has('admin')){
            if(!$user->isVerified){
                return $this->errorResponse('Only verified user can modify the admin field', JsonResponse::HTTP_CONFLICT);
            }

            $user->admin = $request->admin;
        }

        if($user->isClean()){
                return $this->errorResponse('You need to specify a different fields to update', JsonResponse::HTTP_UNPROCESSABLE_ENTITY );
        }

        $user->save();

        if($user->isDirty('email')){
            $user->notify(new EmailChanged());
        }

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user, JsonResponse::HTTP_NO_CONTENT);
    }
}
