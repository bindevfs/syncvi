@foreach($users as $user)
    <tr>
        <td class="text-center text-muted">SVU{{$user->id}}</td>
        <td class="text-center">{{$user->name}}</td>
        <td class="text-center">{{$user->email}}</td>
        <td class="text-center">{{$user->phone}}</td>
        <td class="text-center">{{$user->address}}</td>
        <td class="text-center">
            <div class="badge badge-success">{{$user->numberOrder}}</div>
        </td>
        <td class="text-center">
            <button type="button" data-position="{{$user->id}}" class="disable_user btn btn-primary btn-sm">@if($user->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
        </td>
    </tr>
@endforeach
