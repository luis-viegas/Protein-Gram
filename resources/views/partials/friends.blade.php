<article>

    <div id="friends_list">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($friends as $friend)
                <tr>
                    <td><img class="post-profile-image" src={{$friend->image}}><a href="/users/{{ $friend->id }}">{{$friend->name}}</a></td>
                    <td>{{$friend->email}}</td>
                    @if(Auth::check())
                    @if(Auth::user()->id == $user->id)
                    <td>
                        <form method="post" action="{{route('remove_friend', Auth::user()->id)}}">
                            @csrf
                            <input type="text" name="friend_request_id" value="{{$friend->id}}" hidden >
                            <button type="submit" >Remove Friend </button>
                        </form>
                    </td>
                    @endif
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</article>