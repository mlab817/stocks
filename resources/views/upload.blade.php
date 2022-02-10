@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row">
            <form action="{{ route('upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="file" class="form-control mb-3" accept="text/csv">

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
@endsection
