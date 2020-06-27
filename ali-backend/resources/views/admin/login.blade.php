@extends('admin.auth')
@section('content')
    <div>
        <form method="post" action="{{route('login')}}">
            <h1>Đăng nhập quản trị</h1>
            <input name="email" placeholder="Username" type="email" required="">
            <input name="password" placeholder="Password" type="password" required="">
            <button>Đăng nhập</button>
            {{ csrf_field() }}
        </form>
    </div>
@endsection
