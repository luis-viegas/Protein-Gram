@extends('layouts.app')

@section('content')
<br>
<form method="POST" action="{{ route('createPost') }}">
    {{ csrf_field() }}

    <label for="text">Insert Post's text</label>
    <input id="text" type="text" name="text" required autofocus>

    <button type="submit">
        Create Post
    </button>
    <a class="button button-outline" href="{{ url('/users/'.Auth::user()->id) }}">Cancel</a>
</form>
@endsection
