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
                                    <input class="form-check-input change-status" type="checkbox" role="switch"
                                        id="status-change-{{ $task->id }}" data-task-id="{{ $task->id }}"
                                        @checked($task->status)>
                                    <p class="text-small task-status">{{ $task->status ? 'Completed' : 'Incomplete' }}</p>
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
    <script>
        $(document).ready(function() {

            $('.change-status').on('change', function() {

                var taskId = $(this).data('task-id');
                var status = $(this).is(':checked') ? 1 : 0;
                var textElement = $(this).closest('div').find('.task-status');

                console.log(status);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    url: '{{ url('task/status') }}/' + taskId,
                    type: 'POST',
                    data: {
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            textElement.text(status ? 'Completed' : 'Incomplete')
                        }
                    },
                    error: function(xhr) {
                        console.log('error')
                    }

                });

            });

        });
    </script>
@endpush
