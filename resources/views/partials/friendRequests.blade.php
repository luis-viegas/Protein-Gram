<article>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($friendRequests as $friendRequest)
            <tr>
                <td><img class="post-profile-image" src={{$friendRequest->image}}><a href="users/{{ $friendRequest->id }}">{{$friendRequest->name}}</a></td>
                <td>{{$friendRequest->email}}</td>
                @if(Auth::check())
                @if(Auth::user()->id == $user->id)
                <td>
                    <form method="post" action="{{route('remove_friend_request', Auth::user()->id)}}">
                        @csrf
                        <input type="text" name="friend_request_id" value="{{$friendRequest->id}}" hidden >
                        <button type="submit" >Delete </button>
                    </form>
                </td>
                @endif
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</article>