@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="row-sm-8">
            <div class="card mt-3 p-3">
                <h5 class="text-muted">Fill the details to register!!</h5>
                <form action="{{ route('register')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col">
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            @if($errors->has('name'))
                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                            @if($errors->has('email'))
                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                            @if($errors->has('password'))
                            <span class="text-danger"> {{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="password_confirmation">Password Confirmation</label>
                            <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" />
                            @if($errors->has('password_confirmation'))
                            <span class="text-danger"> {{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-dark">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection