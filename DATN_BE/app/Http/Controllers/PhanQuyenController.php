<?php

namespace App\Http\Controllers;

use App\Models\PhanQuyen;
use Illuminate\Http\Request;

class PhanQuyenController extends Controller
{
    public function store(Request $request)
    {
        $quyen = PhanQuyen::where('id_chuc_vu', $request->id_chuc_vu)
            ->where('id_chuc_nang', $request->id_chuc_nang)
            ->first();

        if ($quyen) {
            return response()->json([
                'status'  => false,
                'message' => 'Quyền đã tồn tại!',
            ]);
        }

        PhanQuyen::create([
            'id_chuc_vu'    => $request->id_chuc_vu,
            'id_chuc_nang'  => $request->id_chuc_nang,
        ]);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã phân quyền thành công!'
        ]);
    }

    public function getData(Request $request)
    {
        $data = PhanQuyen::join('chuc_nangs', 'phan_quyens.id_chuc_nang', 'chuc_nangs.id')
            ->join('chuc_vus', 'phan_quyens.id_chuc_vu', 'chuc_vus.id')
            ->where('phan_quyens.id_chuc_vu', $request->id)
            ->select('phan_quyens.id', 'chuc_nangs.mo_ta', 'chuc_nangs.ten_chuc_nang', 'chuc_vus.ten_chuc_vu')
            ->get();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Lấy dữ liệu phân quyền thành công',
            'data'    =>  $data,
        ]);
    }

    public function destroy(Request $request)
    {
        PhanQuyen::where('id', $request->id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá phân quyền thành công!'
        ]);
    }
}
