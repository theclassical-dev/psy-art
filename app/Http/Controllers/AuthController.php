<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\ProfileImage;


class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'fname'=>'required|string',
            'lname'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'brandName'=>'required|string|unique:users,brandName',
            'tel'=>'required|string|unique:users,tel',
            'password'=>'required|string|confirmed'
        ]);

        //unique_id 
        $bytes = random_bytes(2);
        $date = date('ym');
        $output ='AR|'.$date.'|'.(bin2hex($bytes));

        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'brandName' => $data['brandName'],
            'tel' => $data['tel'],
            'unique_id' => $output,
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

    public function get(Request $request){
        return User::all();
    }

    public function uploadProfileImage(Request $request){
        $data = $request->validate([

            'image' => 'required'
        ]);

        $img = $request->file('image');
        $user = auth()->user()->unique_id;

        if ($request->hasFile('image')) {
            $file = $user.'.'.$img->getClientOriginalName();
            $img->storeAs('profileimage', $file, 'public');
        }

        $pImage = ProfileImage::create([

            'user_id' =>auth()->user()->id,
            'image' =>$file,
        ]);

        $imgRes = [
            'image_url' =>Storage::disk('public')->url('profileimage/'.$file),
            'mime' => $img->getClientMimeType()
        ];

        $response = [
            'message' => 'Successfully uploaded',
            'data' => $pImage,
            'location' => $imgRes
        ];

        return response()->json($response, 201);
    }
}
