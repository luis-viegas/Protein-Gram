@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='User page'>


      <div class='user_grid'>

        <div class='user_item'>
          <img class="user-profile-image" src={{$user->image}}>
          <h1 class="user-field">{{$user->name}}</h1>
          <h5 class="user-field"> {{$user->email}}</h5>
          <p class="user-field"> You don't have permission to see this profile</p>

          @if(Auth::check())
          @if(Auth::user()->id != $user->id && !Auth::user()->friendRequestsMade->contains('id', $user->id) && !Auth::user()->relationships->contains('id', $user->id))
          <form method="post" action="{{ route('create_friend_request',$user->id) }}">
            @csrf
            <button type="submit" > Add Friend </button>
          </form>
          @endif
          @if(Auth::user()->friendRequestsMade->contains('id', $user->id))
            <h5> You already asked this person to be your friend </h5>
          @endif
          @if(Auth::user()->relationships->contains('id', $user->id))
            <h5> You and {{$user->name}} are friends </h5>
          @endif
          @endif

        </div>

      </div>

    </section>
@endsection