@extends('layouts.layout')
@section('content')
    @php

        $users = App\Models\User::where('role', 0)->get();
        $categories = App\Models\Category::latest()->get();

    @endphp
    <div>

        <h1>Add Task</h1>
        <p class="text-danger">{{ session('message') ?? '' }}</p>

        <form class="p-5" method="post" action="{{ route('task.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Deadline</label>
                <input type="date" class="form-control" name="deadline" value="{{ old('deadline') }}">
                @error('deadline')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>File</label>
                <input type="file" class="form-control" name="uploaded_file" accept=".png,.jpg,.jpeg">
                @error('uploaded_file')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Assign To</label>
                <select name="assigned_to[]" class="form-select user-select" multiple>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select">
                    <option value="" selected>Select a Category</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.user-select').select2({
                placeholder: "Select Users",
                allowClear: true
            });
        });
    </script>
@endpush
