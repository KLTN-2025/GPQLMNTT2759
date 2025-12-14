<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NhanVienMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();
        if($user && $user instanceof \App\Models\NhanVien){
            return $next($request);
        }
        else {
            return response()->json([
                'status'    => true,
                'message'   => "Bạn không có quyền truy cập",
            ]);
        }
    }
}
