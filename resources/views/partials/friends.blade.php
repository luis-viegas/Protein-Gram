<article>

    <div id="friends_list">
        @foreach($friends as $friend)
            <div class="friend-card">
                <img class="post-profile-image" src={{$friend->image}}>
                <a href="{{route('show_user',$friend->id)}}">{{$friend->name}}</a>
                {{$friend->email}}
                @if(Auth::check())
                    @if(Auth::user()->id == $user->id)
                        <div>
                            <form method="post" action="{{route('remove_friend')}}">
                                @csrf
                                <input type="text" name="friend_id" value="{{$friend->id}}" hidden>
                                <button type="submit" >Remove Friend </button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
            @endforeach
        
    </div>

</article>