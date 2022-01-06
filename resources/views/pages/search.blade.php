@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($users))
    <h2>We found these users:</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><img class="post-profile-image" src={{$user->image}}><a href="/users/{{ $user->id }}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    {{$message ?? ''}}
</div>
@endsection
