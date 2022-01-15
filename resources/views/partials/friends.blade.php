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
                @foreach($friends as $user)
                <tr>
                    <td><img class="post-profile-image" src={{$user->image}}><a href="/users/{{ $user->id }}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</article>