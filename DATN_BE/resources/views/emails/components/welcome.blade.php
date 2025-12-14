@extends('emails.layouts.master')

@section('title', 'Chào mừng bạn')
@section('header', 'Xin chào!')

@section('content')
    <p>Chào <strong>{{ $user->name }}</strong>,</p>
    <p>Chào mừng bạn đến với hệ thống <b>Hoa Sen School</b>.</p>
    <p>Chúc bạn có trải nghiệm tuyệt vời!</p>
@endsection
