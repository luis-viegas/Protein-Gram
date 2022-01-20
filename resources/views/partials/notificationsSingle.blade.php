@if($notification)
    @switch($notification->type)
        @case('comment')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has commented on your post.</div>
        @break
        @case('post_like')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has liked your post.</div>
        @break
        @case('comment_like')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has liked your comment.</div>
        @break
        @case('comment_tag')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has tagged you in a comment;</div>
        @break
        @case('message')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has messaged you.</div>
        @break
        @case('comment_reply')
            <div class="notification" notification_id="{{$notification->id}}">{{$notification->name}} has replied to your comment.</div>
        @break
    @endswitch
@endif
