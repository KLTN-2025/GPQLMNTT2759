<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Quản Lý Mầm Non API",
 *     version="1.0.0",
 *     description="Tài liệu API cho hệ thống Quản Lý Mầm Non",
 *     @OA\Contact(
 *         email="support@qlmn.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local development server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
