@extends('layouts.app')

@section('title', 'Main Page')

@section('content')

<section class="timeline" id="public timeline">
  @if (Auth::check() && ($showNewPost ?? true) )
    @include('partials.new_post')
  @endif
  @foreach ($posts as $post )
    @if($post->poster->is_private==false)
      @include('partials.post', ['post'=> $post])
    @endif
  @endforeach
</section>

@endsection
