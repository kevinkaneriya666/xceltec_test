@extends('default')

@section('title')
    Dashboard
@endsection

@section('container')
    <div class="container">
        <div class="row">
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
    </div>
    <h2>Welcome, <strong>{{ Auth::guard('admin')->user()->name }}</strong></h2>

    <a href="{{ route('get:logout') }}">Logout</a>

    <a href="{{ route('get:add_user') }}" class="btn btn-info" >Add user</a>
    <table id="users" class="table table-striped">
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if ($users)
              @foreach ($users as $user)
                  <tr>
                      <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                      <td>{{ $user->phone }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                          <img src="{{ asset('profile_images/'.$user->image) }}" height="100px" width="100px" />
                      </td>
                      <td>
                        <div class="checkbox">
                            <label><input class="status" data-id="{{ $user->id }}" type="checkbox" 
                                name="status" value="{{ $user->status }}" @if($user->status == 1) checked @endif>@if($user->status == 1) <span class="d_status_{{ $user->id }}">Active</span> @else <span id="d_status">Inactive</span> @endif</label>
                        </div>
                      </td>
                      <td>
                          <a id="update" class="btn btn-info" href="{{ route('get:edit_user',$user->id) }}">Update</a>
                          <a data-id="{{ $user->id }}" class="btn btn-danger delete" href="javascript:void(0)">Delete</a>
                      </td>
                  </tr>
              @endforeach
          @endif
        </tbody>
      </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){

            $(document).ready( function () {
                $('#users').DataTable({
                    "pageLength": 10
                });
            });

            $('.delete').click(function(){               
                var id = $(this).attr('data-id');
                var conf = confirm("Do you really want to delete user?");
                if(conf){
                    $.ajax({
                        type: 'post',
                        url: "{{ route('post:delete_user') }}",
                        data: {                           
                            id: id,
                            _token: "{{ @csrf_token() }}"
                        },
                        success: function(response){
                            if(response.status == 1){                              
                                window.location.reload();                                    
                            }
                        }
                    });
                }
            });

            $('.status').change(function(){
                var value = $(this).val();
                var id = $(this).attr('data-id');
                if(id){
                    $.ajax({
                        type: 'post',
                        url: "{{ route('post:change_status') }}",
                        data: {
                            status: value,
                            id: id,
                            _token: "{{ @csrf_token() }}"
                        },
                        success: function(response){
                            if(response.status == 1){                                                        
                                $('#status').val(response.status_value);                                
                                if(response.status_value == 1){
                                    $('.d_status_'+response.id).html('Active');
                                } else{
                                    $('.d_status_'+response.id).html('Inactive');
                                }   
                            }
                        }
                    });
                }
            });

        });
    </script>
@endpush