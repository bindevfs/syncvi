@extends('shop.auth')
@section('content')
    <div>
        <form method="post" action="{{ url('admin/register') }}">
            @csrf
            <h1>Đăng ký quản trị</h1>
            <input name="name" placeholder="Name" type="text" required="">
            <input name="email" placeholder="Email" type="email" required="">
            <input name="password" placeholder="Password" type="password" required="">
            <input name="re-password" placeholder="Re-Password" type="password" required="">
            <input name="phone" placeholder="Phone" type="text" required="">
            <button>Đăng ký</button>
        </form>
    </div>
@endsection
