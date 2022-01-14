@extends('layouts.app')

@section('title', 'Main Page')

@section('content')

<section class="timeline" id="public timeline">
  @foreach ($posts as $post )
  @include('partials.post', ['post'=> $post])
  @endforeach
</section>

@endsection
