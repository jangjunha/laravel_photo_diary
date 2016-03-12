@extends('layout')

@section('container')
    @if (isset($title))<h1>{{ $title }}</h1>@endif

    @include('macros.view_errors')

    <form action="{{ $action }}" method="post">
        {{ csrf_field() }}

        <legend>Password</legend>
        <input type="password" id="password" name="password" required>

        @if (isset($confirm) && $confirm)
        <legend>Confirm Password</legend>
        <input type="password" id="confirm_password" name="confirm_password" required>
        @endif

        <input type="submit" id="btn_submit" value="Submit">
    </form>
@endsection

@section('lazy_script')
    @if (isset($confirm) && $confirm)
    <script>
        $(document).ready(function() {
            function validate_password() {
                if ($('#password').val() == $('#confirm_password').val()) {
                    $('#confirm_password').get(0).setCustomValidity('');
                } else {
                    $('#confirm_password').get(0).setCustomValidity("Passwords don't match");
                }
            }

            $('#password').keyup(validate_password);
            $('#confirm_password').keyup(validate_password);
        });
    </script>
    @endif
@endsection
