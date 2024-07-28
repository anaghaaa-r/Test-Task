@extends('layouts.layout')
@section('content')
    <div>


        <h1>Users List</h1>


        <div class="p-5">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ getRole($user->role) }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection
