<?php

namespace App\Http\Controllers;

use App\Models\NamHoc;
use Illuminate\Http\Request;

class NamHocController extends Controller
{
    public function getData(){
        $data = NamHoc::all();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu năm học thành công',
            'data' => $data,
        ]);
    }
}
