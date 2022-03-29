@extends('layouts.app')

@section('content')
    <form action="{{ route('post.test') }}" method="post">
        @csrf
        @for($i=0; $i <10; $i++)
            <div class="row">
                <input name="sched[{{ $i }}][subjects]" type="text" placeholder="Subject {{ $i }}" class="form-control @error('sched.'. $i . '.subjects') is-invalid @enderror">
                @error('sched.'. $i . '.subjects')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <input name="sched[{{ $i }}][units]" type="text" placeholder="Units {{ $i }}"  class="form-control @error('sched.'. $i . '.units') is-invalid @enderror">
                @error('sched.'. $i . '.units')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <input name="sched[{{ $i }}][days]" type="text" placeholder="Days {{ $i }}">
                <input name="sched[{{ $i }}][time]" type="text" placeholder="Time {{ $i }}">
                <input name="sched[{{ $i }}][room]" type="text" placeholder="Room {{ $i }}">
                <input name="sched[{{ $i }}][professor]" type="text" placeholder="Professor {{ $i }}">
            </div>
        @endfor
        <input type="submit" label="Save">
    </form>
@endsection
