@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    <section>
        <h1>Administration</h1>
        All Users:
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
    </section>
@endsection
