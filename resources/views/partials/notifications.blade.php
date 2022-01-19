<div class="notifications tab-closed">
    @foreach($notifications as $genericNotification)
        @php
            $notification = $genericNotification->specific()
        @endphp
        <div class="notification">
            @if($notification)
                @switch($notification->type)
                    @case('comment')
                        {{$notification->name}} has commented on your post.
                    @break
                    @case('post_like')
                        {{$notification->name}} has liked your post.
                    @break
                    @case('comment_like')
                        {{$notification->name}} has liked your comment.
                    @break
                    @case('comment_tag')
                        {{$notification->name}} has tagged you in a comment;
                    @break
                    @case('message')
                        {{$notification->name}} has messaged you.
                    @break
                    @case('comment_reply')
                        {{$notification->name}} has replied to your comment.
                    @break
                @endswitch
            @endif
        </div>
    @endforeach
</div>