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
            <a class="user-groups">GROUPS</a>
            <a class="user-messages" href="/users/{{$user->id}}/messages">MESSAGES</a>
            <a class="user-friends" href="/users/{{$user->id}}/friends">FRIENDS</a>
          </div>

          <div class="user-options">
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

              @if(Auth::user()->is_admin || Auth::user()->id==$user->id)
                  <a class='button' href="{{ url('/users/edit/'.$user->id)}}"> Edit User </a>
                  <a class='button' href="{{ url('/users/delete/'.$user->id)}}"> Delete User </a>
              @endif
              @if(Auth::id()==$user->id)
                <a id='create-post' class="button" href="{{ url('/posts/create')}}"> Create New Post</a>
              @endif

            @endif
          </div>

        </div>

        <div class='posts_item'>
          <section class="profile-timeline" id="profile timeline">
          @foreach ($posts as $post )
          @include('partials.post', ['post'=> $post])
          @endforeach
          </section>
        </div>

      </div>

    </section>
@endsection
