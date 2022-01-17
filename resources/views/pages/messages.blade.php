@extends('layouts.app')

@section('title', $user->name)

@section('content')


<section class="messages-page" id='messages-page'>

<div class="contacts-list">

  @foreach ($chats as $contact)
    @include('partials.contact', ['contact'=> $contact])
  @endforeach
    
</div>

<div class="messages-page-messages">

<div class="message-history">
        @foreach ($messages as $message)
            @if($message->user_id == Auth::user()->id)
            @include('partials.self_message', ['message'=> $message])
            @endif
            @if($message->user_id != Auth::user()->id)
            @include('partials.message_received', ['message'=> $message])
            @endif
        @endforeach
    </div>

  <form id = "message_form" >
    @csrf
    <input id="message_text" type="text" name="text" required autofocus>
    <button type="submit"><i class="fas fa-arrow-circle-right"></i></button>
  </form>
</div>


</section>
@endsection
