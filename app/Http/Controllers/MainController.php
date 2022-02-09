<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\AccDetail;
use App\Models\ArtDetail;
use Auth;
use File;
use URL;



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
        if(!auth()->user()->id){
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
            $file = $img->getClientOriginalName();
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
            "mime" => $img->getClientMimeType()
        ];
        

        $response = [
            'message' => 'successfully uploaded',
            'data' => $art,
            'location' => $imgRes,
        ];

        return response()->json($response, 201);

    }

    public function updateArt(Request $request, $id){

        $d = auth()->user()->artDetail()->find($id);

        $c = Auth::user()->artDetail;

        $img = $request->file('image');

        
        if($d){

            if($request->hasFile('image')){

                $file = $img->getClientOriginalName();
    
                if($file == true){
                    unlink('storage/arts/'.$d->image);
                }
                    $img->storeAs('arts', $file, 'public');
            } 
            else {
                    $file = null;
                }
    
            $d->update([

                'title' => request('title'),
                'size' => request('size'),
                'description' => request('description'),
                'price' => request('price'),
                'discount' => request('discount'),
                'artType' => request('artType'),
                'image' => (is_null($file)) ? $d->image : $file,
            ]);
            
            return [
                'message' => 'successfully updated',
                'data' => $d
            ];
        }

        return [
            'message' => 'error'
        ];

    }

    public function getArt(Request $request){

        $r = auth()->user()->artDetail;

        if(!$r->isEmpty()){

            return $r;
        }

        return [
            'message' => 'No is data available'
        ];
    }

}
