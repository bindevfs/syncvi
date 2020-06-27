@foreach($admins as $admin)
    <tr class="deleteadmin" data-title="{{$admin->id}}">
        <td class="text-center text-muted">SVA{{$admin->id}}</td>
        <td class="text-center">{{$admin->name}}</td>
        <td class="text-center">{{$admin->email}}</td>
        <td class="text-center">{{$admin->phone}}</td>
        <td class="text-center">
            @if ($admin->roles == 1)
                <div class="badge badge-danger">Quản trị</div>
            @elseif ($admin->roles == 2)
                <div class="badge badge-warning">Quản trị viên</div>
            @else
                <div class="badge badge-success">Cộng tác</div>
            @endif
        </td>
        <td class="text-center">
            @if(Auth::guard('admin')->user()->roles == 1)
                <button type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
            @elseif(Auth::guard('admin')->user()->roles == 3)
                <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
            @elseif(Auth::guard('admin')->user()->roles == 2)
                @if($admin->roles == 1)
                    <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                @elseif($admin->roles == 2)
                    <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                @else
                    <button type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                @endif
            @endif
        </td>
    </tr>
@endforeach
