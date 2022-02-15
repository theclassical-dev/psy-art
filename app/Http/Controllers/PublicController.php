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

class PublicController extends Controller
{
    public function artGallery(Request $request){

        $gals = DB::table('users')->
                join('art_details', 'art_details.user_id', 'users.id')->
                select('art_details.id','users.fname','users.lname','users.brandName',
                        'art_details.title','art_details.size','art_details.description',
                        'art_details.price','art_details.discount','art_details.artType',
                        'art_details.image','art_details.status')->get();
        $results = [];
    
        foreach($gals as $gal){
            $gal->image = env('APP_URL') . '/storage/arts/' . $gal->image;
            array_push($results, $gal);
        } 
        return response()->json($results);
    
    }

    public function gen(Request $request){

        $idColumn = mt_rand();
        $dateCode = date('ym');
        $newHumanCode = 'PO-'.$dateCode.substr('0000'.$idColumn, -2);

        $bytes = random_bytes(1);
        $dateCode = date('y');
        $output ='PBR|'.$dateCode.'|'.(bin2hex($bytes));
        return [
            'numberic' => $newHumanCode,
            'alphanumeric' => $output
        ];

    }

    public function searchArt($search){

        $s = DB::table('users')->
            join('art_details', 'art_details.user_id', 'users.id')->
            where('title', 'like', '%'.$search.'%')->
            orWhere('art_details.artType', 'like', '%'.$search.'%')->
            orWhere('fname', 'like', '%'.$search.'%')->
            orWhere('lname', 'like', '%'.$search.'%')->
            orWhere('unique_id', 'like', '%'.$search.'%')->
            orWhere('brandName', 'like', '%'.$search.'%')->get();

        return [
                'data' => $s
            ];
    }
}
