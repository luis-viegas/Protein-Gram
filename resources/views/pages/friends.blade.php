@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='friends-page'>

        <div class="friends-list">
            @isset($friends)
                @include('partials.friends', ['friends'=>$friends, 'user'=>$user ])    
            @endisset
        </div>

        <hr>
        @if(Auth::check())
        @if(Auth::user()->id == $user->id)
        <div class="friend-requests-list">
            @isset($friendRequests)
                @include('partials.friendRequests', ['friendRequests'=>$friendRequests, 'user'=>$user ])    
            @endisset
        </div>
        @endif
        @endif
      

    </section>
@endsection
