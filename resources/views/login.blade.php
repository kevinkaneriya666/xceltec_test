@extends('default')

@section('title')
    Admin Login
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
        </div>
        <div class="row">
            <form method="post" action="{{ route('post:admin_login') }}">
                {{ @csrf_field() }}
                <div class="form-group">
                  <label for="email">Email address:</label>
                  <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" class="form-control" name="password" id="password">
                </div>                
                <button type="submit" class="btn btn-success">Submit</button>
              </form> 
        </div>
    </div>
@endsection