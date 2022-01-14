@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section id='friends-page'>

        <div class="friends-list">
            <div class="friend-overview">
                <div class="friend-pfp">
                    <img src="" alt="">
                </div>
                <div class="friend-name">

                </div>

            </div>
        </div>

        <div class="friend-requests-list">
            <div class="friend-request-overview">
            <div class="friend-request-pfp">
                    <img src="" alt="">
                </div>
                <div class="friend-request-name">

                </div>

                <button class="friend-request-confirm">CONFIRM</button>
                <button class="friend-request-delete">DELETE</button>
            </div>
        </div>
      

    </section>
@endsection
