@extends('layouts.app')

@section('title', $user->name)

@section('content')
<section class="groups-page" id='groups-page'>
@if (Auth::check())
<div class="group-creation">
    <form method="POST" action="{{ route('createGroup') }}">
    @csrf
        {{ csrf_field() }}
        <label for="name">Create a new Group:</label>
        <input class='new-group-input' type="text" name="name" placeholder="What do you want to call your new group, {{$user->name}}?">

        <button type="submit" class="invisible-button">
            Create Post
        </button>
    </form>
</div>
@endif

<h2>My groups:</h2>
<p>To be done</p>

<h2>All groups:</h2>
<div>
    <ul>
    @foreach ($groups as $group )
    <li class="no-dots">
        <a href="/groups/{{$group->id}}">{{$group->name}}</a>
    </li>
    @endforeach
    </ul>
</div>


</section>
@endsection