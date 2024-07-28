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
                        <th scope="col">Assigned To</th>
                        <th>Actions</th>
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

                                {{ status($task->status) }}
                            </td>
                            <td>
                                {{ $task->assignedTo->name }}
                            </td>

                            <td>
                                <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="btn btn-primary">Edit</a>

                                <form action="{{ route('task.delete', ['id' => $task->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger mt-2">Delete</button>

                                </form>
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
