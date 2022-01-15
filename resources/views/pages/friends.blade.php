@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='friends-page'>

        <div class="friends-list">
            @isset($friends)
                @include('partials.friends', ['friends'=>$friends ])    
            @endisset
        </div>

        <hr>

        <div class="friend-requests-list">
            @isset($friendRequests)
                @include('partials.friendRequests', ['friendRequests'=>$friendRequests ])    
            @endisset
        </div>
      

    </section>
@endsection
