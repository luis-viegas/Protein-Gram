@extends('layouts.app')

@section('content')
    <section id='Group page'>
    <div class="groups-wrapper">
        <div class="info">
            <div>
                <h1>{{$group->name}}</h1>
                <h3>Foundation date: </br>{{$group->creationdate}}</h3>
            </div>

            @if(Auth::check())
                @if(Auth::user()->ownerOfGroups()->find($group->id))
                <form method="post" action="{{route('deleteGroup', $group->id)}}">
                    @csrf

                    <button id="group-delete-button" onclick="myFunction()" type="submit" >Delete Group</button>
                    <input type="text" name="id" value="{{$group->id}}" id='delete-group-input' hidden>
                    <script>
                    function myFunction() {
                    alert("You successfully deleted the Group!");
                    }
                    </script>
                </form>

                <form method="post" action="{{route('renameGroup', $group->id)}}">
                    @csrf
                    <input type="text" name="id" value="{{$group->id}}" class="hiden-input" hidden>
                    <label for="name">Group Name:</label>
                    <input type="text" name="name" value="{{$group->name}}" id='rename-group-input'>
                    <button id="group-rename-button" type="submit" >Rename Group</button>
                </form>
                @elseif(Auth::user()->memberOfGroups()->find($group->id))
                <form method="post" action="{{route('leaveGroup', $group->id)}}">
                @csrf
                    <input type="text" name="id" value="{{$group->id}}" class="hiden-input" hidden>
                    <input type="submit" value="Leave Group" />
                </form>
                @else
                <form method="post" action="{{route('joinGroup', $group->id)}}">
                @csrf
                    <input type="text" name="id" value="{{$group->id}}" class="hiden-input" hidden>
                    <input type="submit" value="Join Group" />
                </form>
                @endif
            @endif

            <h4>Group Members:</h4>
            <div class="users-grid">
            <ul>                                             
                @foreach ($group->members as $member )
                <li >
                    <img class="grid-image" src={{Auth::user()->image}}>
                    </br>
                    <h7>{{$member->name}}</h7>
                </li>
                @endforeach
            </ul>
            </div>
        </div>
        <div class="posts">posts</div>
    </div>
        
    
    
    </section>
@endsection