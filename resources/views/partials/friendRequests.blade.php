<article>

    <div id="friend-requests">
        @foreach($friendRequests as $friendRequest)
        <div class="friend-request-card">
            <img class="post-profile-image" src={{$friendRequest->image}}>
            <a href="users/{{ $friendRequest->id }}">{{$friendRequest->name}}</a>
            <div>{{$friendRequest->email}}</div>
            @if(Auth::check())
                @if(Auth::user()->id == $user->id)
                <div class="request-answer">
                    <form method="post" action="{{route('remove_friend_request', Auth::user()->id)}}">
                        @csrf
                        <input type="text" name="friend_request_id" value="{{$friendRequest->id}}" hidden >
                        <button type="submit" >Delete </button>
                    </form>

                    <form method="post" action="{{route('create_friend_request', $friendRequest->id)}}">
                        @csrf
                        <button type="submit" >Accept </button>
                    </form>
                </div>
                
                @endif
                @endif
                </div>
            @endforeach
        
</div>
</article>