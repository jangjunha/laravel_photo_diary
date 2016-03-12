@extends('layout')

@section('container')
    <h1>Upload Image</h1>

    @include('macros.view_errors')

    <form action="{{ URL::route('photos::upload') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <legend>Image</legend>
        <input type="file" id="image" name="image" accept="image/*">

        <legend>Title</legend>
        <input type="text" id="title" name="title">

        <legend>Description</legend>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <input type="submit" id="btn_submit" value="Upload">
    </form>
@endsection
