<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Conversation private channels
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\CuocTroChuyen::find($conversationId);

    if (!$conversation) {
        return false;
    }

    // Check if user is participant (either teacher or parent)
    if ($user instanceof \App\Models\GiaoVien) {
        return $conversation->giao_vien_id === $user->id;
    }

    if ($user instanceof \App\Models\PhuHuynh) {
        return $conversation->phu_huynh_id === $user->id;
    }

    return false;
});

// Group chat private channels
Broadcast::channel('group-chat.{groupId}', function ($user, $groupId) {
    $group = \App\Models\NhomChatLop::with('lopHoc.hocSinhs')->find($groupId);

    if (!$group) {
        return false;
    }

    // Teacher check
    if ($user instanceof \App\Models\GiaoVien) {
        return $group->lopHoc->id_giao_vien === $user->id;
    }

    // Parent check - if parent has student in this class
    if ($user instanceof \App\Models\PhuHuynh) {
        return $group->lopHoc->hocSinhs()
            ->where('id_phu_huynh', $user->id)
            ->exists();
    }

    return false;
});

