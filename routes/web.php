<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestMailController;

Route::get('/', function () {
    return view('emails.components.quenMatKhau');
});
