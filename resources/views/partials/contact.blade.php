<div class="contact">
    <img src="{{$contact->users->where('id','!=', Auth::user()->id)->first()->image}}" alt="pfp">
    <a class="contact-name" href="/messages/{{$contact->id}}">
      {{$contact->users->where('id','<>', Auth::user()->id)->first()->name}}
    </a>
</div>