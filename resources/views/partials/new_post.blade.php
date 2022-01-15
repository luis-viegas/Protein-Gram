<article class="post new-post">

<form method="POST" action="{{ route('createPost') }}">
    {{ csrf_field() }}

    <img class="post-profile-image" src={{Auth::user()->image}}>
    <input type="text" name="text" placeholder="What are you thinking about, {{Auth::user()->name}}?">

    <button type="submit" class="invisible-button">
        Create Post
    </button>
</form>

</article>