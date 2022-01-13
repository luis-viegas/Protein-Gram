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

        </div>

      </div>

    </section>
@endsection