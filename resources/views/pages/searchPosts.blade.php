@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($posts))
    <h2>We found these posts:</h2>
        @foreach($posts as $post)
            @if(!$post->poster->is_private || Auth::user()->is_admin || (Auth::check() && Auth::user()->isFriend($post->user_id)))
                @include('partials.post',['post'=>$post])
            @endif
        @endforeach
    @endif
    {{$message ?? ''}}
</div>
@endsection
