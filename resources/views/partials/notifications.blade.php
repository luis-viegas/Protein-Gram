@foreach($notifications as $genericNotification)
    @include('partials.notificationsSingle', ['notification'=> $genericNotification->specific()])
@endforeach
