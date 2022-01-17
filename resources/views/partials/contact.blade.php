<div class="contact">
    <img src="{{$contact->users->where('id','!=', Auth::user()->id)->first()->image}}" alt="pfp">
    <a class="contact-name" href="/users/{{Auth::user()->id}}/messages/{{$contact->id}}">
      {{$contact->users->where('id','<>', Auth::user()->id)->first()->name}}
    </a>
</div>