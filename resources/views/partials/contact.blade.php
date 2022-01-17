<div class="contact">
    <img src="{{$chat->users->where('id','!=', Auth::user()->id)->first()->image}}" alt="pfp">
    <a class="contact-name" href="/users/{{Auth::user()->id}}/messages/{{$chat->id}}">
      {{$chat->users->where('id','<>', Auth::user()->id)->first()->name}}
    </a>
</div>