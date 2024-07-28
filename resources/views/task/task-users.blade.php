@extends('layouts.layout')
@section('content')
    <div>


        <h1>Task List</h1>
        <p class="text-danger">
            {{ session('message') ?? '' }}
        </p>



        <div class="p-5">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Task Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tasks as $task)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <th>{{ $task->title }}</th>
                            <th>{!! $task->description !!}</th>
                            <td>{{ Carbon\Carbon::parse($task->deadline)->format('d F Y') }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status-change">
                                    <p class="text-small task-status">{{ status($task->status) }}</p>
                                </div>
                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection

@push('scripts')
@endpush
