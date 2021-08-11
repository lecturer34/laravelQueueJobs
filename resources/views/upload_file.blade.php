@extends('layouts.app')
@section('content')
    <div class = "flex justify-center mt-4">
        <div class = "w-8/12 bg-white p-6 rounded-lg">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf 
                <input type="file" name="myjson">
                <input type="submit" value="Upload" class="">
            </form>
        </div>
    </div>
@endsection()