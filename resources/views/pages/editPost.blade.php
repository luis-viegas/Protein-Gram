@extends('layouts.app')

@section('content')
<form method="POST" action="{{ Auth::user()->is_admin? route('update_post_admin', $post->user_id) : route('update_post') }}">
    {{ csrf_field() }}
    <input id="id" type="text" name="id" value="{{$post->id}}" hidden>
    <label for="text">Update Post's text</label>
    <input id="text" type="text" name="text" value="{{$post->text}}" required autofocus>

    <button type="submit">
        Update Post
    </button>
    <a class="button button-outline" href="{{ url('/users/'.Auth::user()->id) }}">Cancel</a>
</form>
@endsection
