@extends('default')

@section('title')
    @if(isset($user_data)) Edit User @else Add User @endif
@endsection

@section('container')
    <div class="container">
        <div class="row">
            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
        <div class="row">
            <form method="post" action="{{ route('post:add_user') }}" enctype="multipart/form-data">
                {{ @csrf_field() }}
                @if(isset($user_data))
                    <input type="hidden" value="{{ $user_data->id }}" name="id" />
                @endif
                <div class="form-group">
                  <label for="fname">First Name:</label>
                  <input type="text" class="form-control" value="{{ isset($user_data) ? $user_data->first_name : old('fname') }}" name="fname" id="fname">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" value="{{  isset($user_data) ? $user_data->last_name : old('lname') }}" name="lname" id="lname">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" class="form-control" value="{{  isset($user_data) ? $user_data->dob : old('dob') }}" name="dob" id="dob">
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" value="{{  isset($user_data) ? $user_data->email : old('email') }}" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="phone" class="form-control" value="{{  isset($user_data) ? $user_data->phone : old('phone') }}" name="phone" id="phone">
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                @if (!isset($user_data))
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div> 
                @endif
                                  
                <button type="submit" class="btn btn-success">@if(isset($user_data)) UPDATE @else ADD @endif</button>
              </form> 
        </div>
        </div>
    </div>
@endsection