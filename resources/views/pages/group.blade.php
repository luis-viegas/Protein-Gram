@extends('layouts.app')

@section('content')
    <section id='Group page'>
        <div>
            <h1>{{$group->name}}</h1>
            <h3>{{$group->creationdate}}</h3>
        </div>

        @foreach ($group->members as $member )
        <p>{{$member->name}}</p>
        @endforeach
    
        @if(Auth::check() )

        <form method="post" action="{{route('deleteGroup', $group->id)}}">
            @csrf

            <button id="group-delete-button" onclick="myFunction()" type="submit" >Delete Group</button>
            <input type="text" name="id" value="{{$group->id}}" id='delete-group-input'>
            <script>
            function myFunction() {
            alert("You successfully deleted the Group!");
            }
            </script>
        </form>

        <form method="post" action="{{route('renameGroup', $group->id)}}">
            @csrf
            <input type="text" name="id" value="{{$group->id}}" class="hiden-input">
            <label for="name">Group Name:</label>
            <input type="text" name="name" value="{{$group->name}}" id='rename-group-input'>
            <button id="group-rename-button" type="submit" >Rename Group</button>
        </form>
        @endif
    
    
    </section>
@endsection