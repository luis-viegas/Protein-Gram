<article class="post" data-id="{{ $post->id}}">
    <div id="post-info">
        <img class="post-profile-image" src={{$post->poster->image}}>
        <a id="post-username" href="/users/{{ $post->user_id}}">{{$post->poster->name}}</a>
        <div id="post-created">  {{ $post->created_at }} </div>
    </div>

    @if($post->updated_at!=$post->created_at)
        <div id="post-updated">{{$post->updated_at}} </div>
    @endif
  
    <div id="post-text"><p>{{$post->text}}</p></div>

    <div id="like_form">
        @if(Auth::check() )
        @if(!$post->likes->find(Auth::user()->id))
        <button class= "like_button" id="like_b{{ $post->id }}"><i class="fas fa-thumbs-up"></i></button>
        @endif
        @endif
        <div class="like_number" id="like_n{{ $post->id }}"> 
            {{ $post->likes->count()}}
            @if ($post->likes->count() == 1)
             Like
             @endif
             @if ($post->likes->count() != 1)
             Likes
             @endif
            </div>
    </div>


    <div id="post-comments">
        @foreach ($post->comments as $comment )
            @if($comment->reply_to==null)
                @include('partials.comment', ['comment'=> $comment])
            @endif
        @endforeach
        @if(Auth::check() )
        <form class = "create-comment" method="post" action="{{route('create_comment')}}">
            @csrf
            <input type="text" name="message" placeholder="new comment">
            <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}" hidden>
            <input class="button" type="submit" value="New Comment">
        </form>
        @endif
    </div>
    

    




    <div id="post-actions">
    @if(Auth::id()== $post->user_id)
        <a id="post-edit-button" class="button" href="{{ url('/posts/edit/'.$post->id) }}"> Edit </a>
    @endif

    @if(Auth::check() )
        @if(Auth::user()->is_admin || Auth::id()== $post->user_id)
        <form method="post" action="{{ Auth::user()->is_admin ? route('delete_post_admin', $post->user_id) : route('delete_post') }}">
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
