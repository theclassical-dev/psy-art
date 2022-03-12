<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'password' => 'required|string|'
        ]);

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $admin->createToken('adminToken')->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // check admin email
        $admin = Admin::where('email', $data['email'])->first();

        if(!$admin || !Hash::check($data['password'], $admin->password)){
            return response(['message' => 'not found']);
        }

        $token = $admin->createToken('adminToken')->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function logout(Request $request){
        auth()->guard('admin')->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function get(Request $request){
        return auth()->guard('admin')->user()->email;
    }
}
