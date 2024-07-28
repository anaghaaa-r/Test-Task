@extends('layouts.layout')
@section('content')
    <div>


        <h1>Register</h1>
        <p class="text-danger">{{ session('message') ?? '' }}</p>

        <form class="p-5" method="post" action="{{ route('register.submit') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
                @error('password')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
