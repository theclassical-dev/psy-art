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
use DB;

class BossController extends Controller
{
    public function get(Request $request){
        return User::all();
    }

    public function artArtwork(Request $request){

        $gals = DB::table('users')->
                join('art_details', 'art_details.user_id', 'users.id')->
                select('art_details.id','users.fname','users.lname','users.brandName',
                        'art_details.title','art_details.size','art_details.description',
                        'art_details.price','art_details.discount','art_details.artType',
                        'art_details.image',)->get();
        $results = [];
    
        foreach($gals as $gal){
            $gal->image = env('APP_URL') . '/storage/arts/' . $gal->image;
            array_push($results, $gal);
        } 
        return response()->json($results);
    
    }
}
