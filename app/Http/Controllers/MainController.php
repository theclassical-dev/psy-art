<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\AccDetail;
use App\Models\ArtDetail;


class MainController extends Controller
{
    public function createAccDetail(Request $request) {
        $data = $request->validate([
            'bank' => 'required|string',
            'accType' => 'required|string',
            'accName' => 'required|string|unique:acc_details,accName',
            'accNumber' => 'required|string|unique:acc_details,accNumber',
        ]);

        $acc = AccDetail::create([
            'bank' => $data['bank'],
            'accType' => $data['accType'],
            'accName' => $data['accName'],
            'accNumber' => $data['accNumber'],
            'user_id' => auth()->user()->id,
        ]);

        return $acc;
    }

    public function updateAccDetail(Request $request, $id) {
        $id = auth()->user()->id;
        if(!auth()->user()){
            return [
                'message' => 'unauthorized'
            ];
        }
        $acc = AccDetail::find($id);
        $acc->update($request->all());
        return $acc;

    }

    public function uploadArt(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'size' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'discount' => 'nullable|string',
            'artType' => 'required|string',
            'image' => 'required',
        ]);

        $img = $request->file('image');

        if($request->hasFile('image')){
            $file = rand().'.'.$img->getClientOriginalName();
            $img->storeAs('arts', $file, 'public');
        }
        
        $art = ArtDetail::create([
            'title' => $data['title'],
            'size' => $data['size'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'artType' => $data['artType'],
            'image' => $file,
            'user_id' => auth()->user()->id
        ]);
        
        $imgRes = [
            "image_url" => Storage::disk('public')->url('arts/'.$file),
            "mime" => $img->getClientMimeType(),
        ];
        

        $response = [
            'details' => $art,
            'location' => $imgRes,
        ];

        return response([$response, 201]);

    }
}
