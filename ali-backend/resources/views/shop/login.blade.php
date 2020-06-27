@extends('shop.auth')
@section('content')
    <div>
        <form method="post" action="{{route('shop.login')}}">
            <h1>Đăng nhập cửa hàng</h1>
            <input name="email" placeholder="Email" type="email" required>
            <input name="password" placeholder="Password" type="password" required>
            <button>Đăng nhập</button>
            {{ csrf_field() }}
        </form>
    </div>
@endsection
