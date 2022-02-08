<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
}
