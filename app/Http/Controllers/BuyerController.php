<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Buyer;

class BuyerController extends Controller
{
    public function Bregister(Request $request) {
        $data = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|string|unique:buyers,email',
            'username' => 'required|string|unique:buyers,username',
            'tel' => 'required|string|unique:buyers,tel',
            'password' => 'required',
        ]);

        $bytes = random_bytes(1);
        $date = date('y');
        $output ='PBR|'.$date.'|'.(bin2hex($bytes));

        $buyer = Buyer::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'username' => $data['username'],
            'tel' => $data['tel'],
            'unique_id' => $output,
            'password' => bcrypt($data['password'])
        ]);

        $token = $buyer->createToken('buyerToken')->plainTextToken;

        $response =  [
            'buyer' => $buyer,
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
