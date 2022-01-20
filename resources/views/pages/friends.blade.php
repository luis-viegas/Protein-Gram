@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='friends-page'>

        <div class="tabs">
            <div class="active-tab" id="friends-list-tab">FRIENDS</div>
            <div id="friend-requests-tab">FRIEND REQUESTS</div>
        </div>

        <div id="friends-content">
            <div id="friends-list">
                @isset($friends)
                    @include('partials.friends', ['friends'=>$friends, 'user'=>$user ])    
                @endisset
            </div>

            @if(Auth::check())
            @if(Auth::user()->id == $user->id)
            <div id="friend-requests-list">
                @isset($friendRequests)
                    @include('partials.friendRequests', ['friendRequests'=>$friendRequests, 'user'=>$user ])    
                @endisset
            </div>
            @endif
            @endif
        </div>

        
      

    </section>
@endsection
