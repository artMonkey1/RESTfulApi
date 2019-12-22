<?php

namespace App\Http\Controllers\v1\User;

use App\Models\User;
use App\Http\Controllers\v1\ApiController;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->showCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['verified'] = User::UNVERIFIED_USER;
        $input['verification_token'] = User::generateVerificationCode();
        $input['admin'] = User::ADMIN_USER;

        $user = User::create($input);

        return $this->showOne($user,JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
        'email' => ['email', 'unique:user,email,' . $user->id],
        'password' => ['min:6', 'confirmed'],
        'admin' => ['in:' . User::ADMIN_USER . ',' . User::REGULAR_USER]
        ];

        $this->validate($request, $rules);

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

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->showOne($user, JsonResponse::HTTP_NO_CONTENT);
    }
}
