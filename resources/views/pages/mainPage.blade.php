@extends('layouts.app')

@section('title', 'Main Page')

@section('content')

<section id="public timeline">
  @foreach ($posts as $post )
    @if($post->poster->is_private==false)
    @include('partials.post', ['post'=> $post])
    @endif
  @endforeach
</section>

@endsection
