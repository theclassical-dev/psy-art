<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;


class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'fname'=>'required|string',
            'lname'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'brandName'=>'required|string|unique:users,brandName',
            'tel'=>'required|string|unique:users,tel',
            'unique_id'=>'required|string|unique:users,unique_id',
            'password'=>'required|string|confirmed'
        ]);

        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'brandName' => $data['brandName'],
            'tel' => $data['tel'],
            'unique_id' => $data['unique_id'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check user 
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response(['message' => 'check inserted details'], 401);
        }
        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
