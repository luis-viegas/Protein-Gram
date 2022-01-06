@extends('layouts.app')

@section('title', 'Main Page')

@section('content')

<section id="public timeline">
  @foreach ($posts as $post )
  @include('partials.post', ['post'=> $post])
  @endforeach
</section>

@endsection
