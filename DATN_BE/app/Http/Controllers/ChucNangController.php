<?php

namespace App\Http\Controllers;

use App\Models\ChucNang;
use Illuminate\Http\Request;

class ChucNangController extends Controller
{
    public function getData(){
        $data =ChucNang::all();

        return response()->json([
            'status' => 1,
            'data' => $data,
        ]);
    }
}
