<article class="post new-post">

<form method="POST" action="{{ route('createGroupPost' , $group->id) }}">
    {{ csrf_field() }}

    <img class="post-profile-image" src={{Auth::user()->image}}>
    <input type="text" name="id" value="{{$group->id}}" class="hiden-input" hidden>
    <input type="text" name="text" placeholder="Post anything you want in {{$group->name}}!">

    <button type="submit" class="invisible-button">
        Create Post
    </button>
</form>

</article>