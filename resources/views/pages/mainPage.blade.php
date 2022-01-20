@extends('layouts.app')

@section('title', 'Main Page')

@section('content')

<section class="timeline" id="public timeline">
  @if (Auth::check() && ($showNewPost ?? true) )
    @include('partials.new_post')
  @endif
  @foreach ($posts as $post )
    @if($post->poster->is_private==false || (Auth::check() && ( Auth::user()->is_admin || $post->user_id == Auth::id() || Auth::user()->isFriend($post->poster_id))) )
      @include('partials.post', ['post'=> $post])
    @endif
  @endforeach
</section>

@endsection
