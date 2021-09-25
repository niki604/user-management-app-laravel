@extends('master')

@section('content')

    <div class="ml-3 relative">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-primary" type="submit" style="float: right" onclick="event.preventDefault();
            this.closest('form').submit();">Log Out</button>
        </form>
    </div>


@endsection