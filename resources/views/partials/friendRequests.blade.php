<article>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($friendRequests as $user)
            <tr>
                <td><img class="post-profile-image" src={{$user->image}}><a href="users/{{ $user->id }}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                @if(Auth::check())
                <td>
                    <form method="post" action="{{route('remove_friend_request', Auth::user()->id)}}">
                        @csrf
                        <input type="text" name="friend_request_id" value="{{$user->id}}" hidden >
                        <button type="submit" >Delete </button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</article>