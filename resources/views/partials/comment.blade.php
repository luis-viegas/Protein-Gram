<article class="comment" data-id="{{$comment->id}}">
    {{$comment->commentor->name}}: {{$comment->message}}

    @if($comment->reply_to==null && Auth::check())
        <button class='respond_button' id="respond_{{$comment->id}}" >Respond </button>
    @endif

    <div class=comment_replies>
        @foreach ($comment->replies as $reply )
            @include('partials.comment', ['comment'=> $reply])
        @endforeach
        @if($comment->reply_to==null)
            <form class =response_form  id="response_form_{{$comment->id}}" method="POST" action="{{route('create_comment')}}">
                <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}" hidden>
                <input type="hidden" id="comment_id" name="comment_id" value="{{$comment->id}}" hidden>
                @csrf
            </form>
            <script>
                document.getElementById("respond_{{$comment->id}}").addEventListener('click',function(){
                    document.getElementById("response_form_{{$comment->id}}").innerHTML+='<input type="text" name="message" id="reply_comment_text" placeholder="new comment"> <input class="button" id="create_comment_reply" type="submit" value="Response">';
                    document.getElementById("respond_{{$comment->id}}").style.display='none';
                })
            </script>
        @endif
        <hr>
    </div>
</article>

