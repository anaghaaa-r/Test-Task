@extends('layouts.layout')
@section('content')
    <div>


        <h1>Register</h1>

        <form class="p-5" id="registerForm">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                <div class="form-text text-danger" id="nameError"></div>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" id="email" name="email" value="{{ old('email') }}">
                <div class="form-text text-danger" id="emailError"></div>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-text text-danger" id="passwordError"></div>
            </div>


            <button type="submit" id="registerSubmit" class="btn btn-primary">Submit</button>
            <div class="text-danger" id="message"></div>
        </form>
    </div>


    <div>
        <form action="{{ route('reset.password') }}" method="POST">
            @csrf
            <input type="text" name="current_password" id="">
            <input type="text" name="new_password" id="">
            <input type="text" name="confirm_password" id="">

            <button type="submit">reset</button>
            {{ session('message') }}
            {{ $errors }}
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#registerSubmit').on('click', function(event) {
                event.preventDefault();

                $('#nameError').text('');
                $('#emailError').text('');
                $('#passwordError').text('');
                $('#message').text('');

                var formData = $('#registerForm').serialize();

                console.log(formData);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    url: '{{ route('register.submit') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            $('#message').text(response.message)
                            // $('#registerForm')[0].reset();
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#message').text('Registeration Failed')
                        }
                    },
                    error: function(response) {
                        console.log(response)
                        var errors = response.responseJSON.errors;

                        if (errors.name) {
                            $('#nameError').text(errors.name[0]);
                        }


                        if (errors.email) {
                            $('#emailError').text(errors.email[0]);
                        }

                        if (errors.password) {
                            $('#passwordError').text(errors.password[0]);
                        }
                    }

                });
            });
        });
    </script>
@endpush
