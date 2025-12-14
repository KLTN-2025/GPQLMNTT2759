@extends('emails.layouts.master')

@section('title', $tieuDe)

@section('header', 'Thông Báo Mới')

@section('content')
<div style="padding: 20px;">
    <h3 style="color: #0d6efd; margin-bottom: 15px;">{{ $tieuDe }}</h3>

    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
        <p style="line-height: 1.8; color: #333; margin: 0; white-space: pre-wrap;">{{ $noiDung }}</p>
    </div>

    @if(isset($loaiThongBao))
    <div style="margin-top: 20px; padding: 10px; background: #e7f3ff; border-left: 4px solid #0d6efd; border-radius: 4px;">
        <p style="margin: 0; color: #666;">
            <strong>Loại thông báo:</strong>
            @switch($loaiThongBao)
            @case(0) Toàn Trường @break
            @case(1) Theo Lớp @break
            @case(2) Cá Nhân @break
            @case(3) Hệ Thống @break
            @case(4) Sự Kiện @break
            @case(5) Khẩn Cấp @break
            @default Thông báo
            @endswitch
        </p>
    </div>
    @endif

    @if(isset($nguoiGui))
    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
        <p style="color: #666; font-size: 14px; margin: 0;">
            <strong>Người gửi:</strong> {{ $nguoiGui }}<br>
            <strong>Thời gian:</strong> {{ $thoiGian ?? now()->format('d/m/Y H:i') }}
        </p>
    </div>
    @endif

    <div style="margin-top: 25px; padding: 15px; background: #fff3cd; border-radius: 8px;">
        <p style="margin: 0; color: #856404; font-size: 14px;">
            ⓘ Đây là email tự động từ hệ thống. Vui lòng không trả lời email này.
        </p>
    </div>
</div>
@endsection