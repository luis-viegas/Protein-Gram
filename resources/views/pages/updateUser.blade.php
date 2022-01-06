@extends('layouts.app')

@section('content')
<br>
<form method="POST" action="{{ route('editUser', $user->id) }}">
    {{ csrf_field() }}

    <label for="name">Nome</label>
    <input id="name" type="text" name="name" value="{{ $user->name }}" required>

    <label for="image">Image URL</label>
    <input id="image" type="text" name="image" placeholder="Insert the url of the image you want - leave blanc if you don't want to change">

    <label for="bio">Description </label>
    <input id="user-bio" type="text" name="bio" value="{{ $user->bio }}" required>

    <label for="is_private"> Private Profile</label>
    <input id="is_private" type="text" name="is_private" value="{{ $user->is_private ? 'true':'false' }}" required>

    @if(Auth::check())
        @if(Auth::user()->is_admin && Auth::user()->id!=$user->id)
        <label for="is_admin"> Admin Profile</label>
        <input type="text" name="is_admin" value="{{ $user->is_admin ? 'true':'false'}}" required>
        @endif
        @if(Auth::user()->is_admin && Auth::user()->id==$user->id)
        <input id="edit-own-admin" type="text" name="is_admin" value="{{ $user->is_admin ? 'true':'false'}}" required>
        @endif
    @endif
    <button type="submit">
        Edit
    </button>

</form>
@endsection
