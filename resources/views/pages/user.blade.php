@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='User page'>
      <div class='user_grid'>
        <div class='user_item'>
          <img class="user-profile-image" src={{$user->image}}>
          <h1 class="user-field">{{$user->name}}</h1>
          <h5 class="user-field"> {{$user->email}}</h5>
          <p class="user-field"> {{$user->bio}}</p>
          <div class="user-short-links">
            <a class="user-groups" href="/groups">GROUPS</a>
            @if(Auth::check() && Auth::user()->id == $user->id)
              <a class="user-messages" href="/messages">MESSAGES</a>
            @endif
            <a class="user-friends" href="/users/{{$user->id}}/friends">FRIENDS</a>
          </div>
          <div class="user-options">
            @if(Auth::check())
              @if(Auth::user()->isFriend($user->id))
                <h5> You and {{$user->name}} are friends </h5>
              @else
                @if(Auth::user()->id != $user->id && !Auth::user()->friendRequestsMade->contains('id', $user->id) && !Auth::user()->isFriend($user->id))
                  <form method="post" action="{{ route('create_friend_request') }}">
                    @csrf
                    <input type="text" name="friend_request_id" value="{{$user->id}}" hidden>
                    <button type="submit" > Add Friend </button>
                  </form>
                @endif
                @if(Auth::user()->friendRequestsMade->contains('id', $user->id))
                  <h5> You have asked this person to be your friend </h5>
                @endif
              @endif
              @if(Auth::id()==$user->id)
                <a class='button' href="{{ url('/users/edit/'.$user->id)}}"> Edit User </a>
                <a class='button' href="{{ url('/users/delete/'.$user->id)}}"> Delete User </a>
                @if(!Auth::user()->is_admin)
                  <a id='create-post' class="button" href="{{ url('/posts/create')}}"> Create New Post</a>
                @endif
              @else
                <form method="post" action="{{ route('createChat', $user->id) }}">
                  @csrf
                  <button type="submit" > Send Message </button>
                </form>
              @endif
            @endif
          </div>
        </div>
        <div class='posts_item'>
          @if (Auth::check() )
          @include('partials.new_post')
          @endif
          <section class="profile-timeline" id="profile timeline">
          @foreach ($posts as $post )
          @include('partials.post', ['post'=> $post])
          @endforeach
          </section>
        </div>
      </div>
    </section>
@endsection
