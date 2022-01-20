@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='User page'>
      <div class='user_grid'>
        <div class='user_item'>
          <img class="user-profile-image" src={{$user->image}}>
          <h1 class="user-field">{{$user->name}}</h1>
          <h5 class="user-field"> {{$user->email}}</h5>
          @if(Auth::check())
            @if(Auth::user()->isFriend($user->id))
              <h5> You and {{$user->name}} are friends </h5>
            @else
              @if(!(Auth::user()->is_admin))
                <p class="user-field"> You don't have permission to see this profile</p>
              @endif
              @if(! (Auth::user()->sentFriendRequest($user->id)) )
                <form method="post" action="{{ route('create_friend_request') }}">
                  @csrf
                  <input type="text" name="friend_request_id" value="{{$user->id}}" hidden>
                  <button type="submit" > Add Friend </button>
                </form>
              @else
                <h5> You have asked this person to be your friend </h5>
              @endif
            @endif
           
          @endif
          
        </div>

      </div>

    </section>
@endsection