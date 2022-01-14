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

          @if(Auth::check())
            @if(Auth::user()->is_admin || Auth::user()->id==$user->id)
                <a class='button' href="{{ url('/users/edit/'.$user->id)}}"> Edit User </a>
                <a class='button' href="{{ url('/users/delete/'.$user->id)}}"> Delete User </a>
            @endif
            @if(Auth::id()==$user->id)
              <a id='create-post' class="button" href="{{ url('/posts/create')}}"> Create New Post</a>
            @endif

          @endif
        </div>

        <div class='posts_item'>
            <section id="profile timeline">
            @foreach ($posts as $post )
            @include('partials.post', ['post'=> $post])
            @endforeach
          </section>
        </div>

      </div>

    </section>
@endsection
