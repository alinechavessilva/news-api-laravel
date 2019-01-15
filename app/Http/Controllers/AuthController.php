<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\User;

class AuthController extends BaseController
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $user = Auth::user();

            $success['token'] =  $user->createToken('indexdigital')-> accessToken;

            return $this->sendResponse(['success' => $success], 'User logged successfully.');

        }

        return $this->sendError(['error'=>'Unauthorised'], 'User invalid.', 401);

    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
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

}
