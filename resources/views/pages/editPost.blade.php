@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('updatePost', $post->id) }}">
    {{ csrf_field() }}

    <label for="text">Update Post's text</label>
    <input id="text" type="text" name="text" value="{{$post->text}}" required autofocus>

    <button type="submit">
        Update Post
    </button>
    <a class="button button-outline" href="{{ url('/users/'.Auth::user()->id) }}">Cancel</a>
</form>
@endsection
