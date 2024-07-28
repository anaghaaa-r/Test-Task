@extends('layouts.layout')
@section('content')
    <div>

        <h1>Categories</h1>
        <p class="text-danger">{{ session('message') ?? '' }}</p>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
            Add Category
        </button>

        <!-- Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="categoryModalLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" method="post" action="{{ route('category.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Title</label>
                                <input class="form-control" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editCategory{{ $category->id }}">
                                Edit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1"
                                aria-labelledby="editCategory{{ $category->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editCategory{{ $category->id }}Label">Update
                                                Category</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="p-2" method="post"
                                                action="{{ route('category.save', ['id' => $category->id]) }}">
                                                @csrf

                                                <div class="mb-3">
                                                    <label>Title</label>
                                                    <input class="form-control" name="title"
                                                        value="{{ old('title', $category->title) }}">
                                                    @error('title')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label>Description</label>
                                                    <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description', $category->description) }}</textarea>
                                                    @error('description')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>


                            {{-- delete --}}
                            <form action="{{ route('category.delete', ['id' => $category->id]) }}" method="POST">
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
@endsection


@push('scripts')
    @if (session('save_error'))
        <script>
            $(document).ready(function() {
                $('#categoryModal').modal('show');
            });
        </script>
    @endif
@endpush
