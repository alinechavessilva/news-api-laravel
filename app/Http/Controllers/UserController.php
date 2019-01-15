<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class UserController extends BaseController
{
    public function index(){

        return $this->sendResponse(User::orderBy('id', 'desc')->get(), 'User retrieved successfully.');

    }

    public function show(){

        return $this->sendResponse(Auth::user(), 'User retrieved successfully.');

    }


    public function store(Request $request)
    {
        $request->validate( [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'repeat_password' => 'required|same:password',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        $token = $user->createToken('indexdigital')-> accessToken;
        $user->remember_token = $token;

        if($user->save()) {

            $success['token'] = $token;

            return $this->sendResponse(['success' => $success], 'User created successfully.');
        }

        return $this->sendError('Error creating user', 'Error creating user');

    }

    public function update($id, Request $request){

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->slug = $request->input('slug');

        if($user->save()){

            return $this->sendResponse($user, 'User updated successfully.');
        }

        return $this->sendError('Error updating user', 'Error updating user');

    }

    public function destroy($id){

        $user = User::find($id);

        if($user->delete()){

            return $this->sendResponse($id, 'User deleted successfully.');
        }

        return $this->sendError('Error deleting user', 'Error deleting user');

    }

}
