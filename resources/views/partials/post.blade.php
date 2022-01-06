<!--
<article class="post" data-id="{{ $post->id}}">
<header>
    <p style="text-align: left;"><a href="/users/{{ $post->user_id}}">{{$post->name}}</a>
    <span style="text-align: right;"> Created at:{{ $post->created_at }} </span>
    @if($post->updated_at!=$post->created_at)
        <br>Modified at: {{$post->updated_at}} </br>
    @endif
    @if(Auth::id()== $post->user_id)
        <a class="button" href="{{ url('/posts/edit/'.$post->id) }}"> Edit </a>
    @endif
    @if(Auth::id()== $post->user_id )
        @if(Auth::user()->is_admin)
        <form method="post" action="{{route('deletePost', $post->user_id)}}">
            @csrf
            <input type="text" name="id" value="{{$post->id}}" id='delete-post-input'></input>
            <button type="submit" >Delete </button>
        </form>
        @endif
    @endif

    </p>
</header>
<body>
    {{$post->text}}
    <hr>
</body>
</form>
</article>
-->

<article class="post" data-id="{{ $post->id}}">
    <div id="post-info">
        <img class="post-profile-image" src={{$post->image}}>
        <a id="post-username" href="/users/{{ $post->user_id}}">{{$post->name}}</a>
        <div id="post-created">  Created at:{{ $post->created_at }} </div>
    </div>

    @if($post->updated_at!=$post->created_at)
        <div id="post-updated">Modified at: {{$post->updated_at}} </div>
    @endif
    <hr>
    <div id="post-text"><p>{{$post->text}}</p></div>

    <div id="post-actions">
    @if(Auth::id()== $post->user_id)
        <a id="post-edit-button" class="button" href="{{ url('/posts/edit/'.$post->id) }}"> Edit </a>
    @endif
    @if(Auth::check() )
        @if(Auth::user()->is_admin || Auth::id()== $post->user_id)
        <form method="post" action="{{route('deletePost', $post->user_id)}}">
            @csrf
            <input type="text" name="id" value="{{$post->id}}" id='delete-post-input'>
            <button id="post-delete-button" onclick="myFunction()" type="submit" >Delete </button>
            <script>
            function myFunction() {
            alert("You successfully deleted the post!");
            }
            </script>
        </form>
        @endif
    @endif
    </div>

</article>
