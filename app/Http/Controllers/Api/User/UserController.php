<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

        return response()->json(['data' => $users, 'code' => 200], 200);
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

        return response()->json(['data' => $user, 'code' => 201], 201);
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

        return response()->json(['data' => $user, 'code' => 200], 200);
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
                return response()->json(['error' => 'Only verified user can modify the admin field', 'code' => 409], 409);
            }

            $user->admin = $request->admin;
        }

        if($user->isClean()){
                return response()->json(['error' => 'You need to specify a different fields to update', 'code' => 422], 422);
        }

        $user->save();

        return response()->json(['data' => $user, 'code' => 200], 200);
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

        return response()->json(['data' => $user], 204);
    }
}
