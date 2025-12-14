<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSuChat extends Model
{
    protected $table = 'lich_su_chats';
    protected $fillable = [
        'nguoi_gui',
        'nguoi_nhan',
        'noi_dung',
    ];
}
