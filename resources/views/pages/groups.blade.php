@extends('layouts.app')

@section('title', $user->name)

@section('content')
<section class="groups-page" id='groups-page'>
@if (Auth::check())
<form method="POST" action="{{ route('createGroup') }}">
@csrf
    {{ csrf_field() }}

    <input type="text" name="name" placeholder="What are you thinking about, {{$user->name}}">

    <button type="submit" class="invisible-button">
        Create Post
    </button>
</form>
@endif
</section>

@foreach ($groups as $group )
    <p><a href="/groups/{{$group->id}}">{{$group->name}}</p>
  @endforeach
@endsection