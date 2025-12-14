<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GiaoVienMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('giao_vien')->user() ?: Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\GiaoVien) {
            return $next($request);
        } else {
            return response()->json([
                'status'    => true,
                'message'   => "Bạn không có quyền truy cập",
            ]);
        }
    }
}
