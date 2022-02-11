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


class PublicController extends Controller
{
    public function artGallery(Request $request){

        $gals = ArtDetail::select(
            'id','title','size','description',
            'price','discount','artType','image',
            )->get();
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

        $bytes = random_bytes(2);
        $dateCode = date('y-m');
        $output ='AR|'.$dateCode.'|'.(bin2hex($bytes));
        return [
            'numberic' => $newHumanCode,
            'alphanumeric' => $output
        ];

    }
}
