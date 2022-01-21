@extends('layouts.app')

@section('content')
    <section id='Group page'>
    <div class="groups-wrapper">
        <div class="info">
            <div>
                <h1>{{$group->name}}</h1>
                <h5>Foundation date: </br>{{substr($group->creationdate, 0, strpos($group->creationdate, " " ))}}</h5>
            </div>

            @if(Auth::check())
                @if(Auth::user()->ownerOfGroups()->find($group->id))

                <form method="post" action="{{route('renameGroup', $group->id)}}">
                    @csrf
                    <input type="text" name="id" value="{{$group->id}}" class="hiden-input" hidden>
                    <label for="name">Rename this group:</label>
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


            <h4>Group Owners:</h4>
            <div class="users-grid">
            <ul>                                             
                @foreach ($group->owners as $member )
                <li >
                    <a href='/users/{{$member->id}}'>
                        <img class="grid-image" src={{$member->image}}>
                        </br>
                        <h7>{{$member->name}}</h7>
                    </a>
                </li>
                @endforeach
            </ul>
            </div>

            <h4>Group Members:</h4>
            <div class="users-grid">
            <ul>                                             
                @foreach ($group->members as $member )
                <li >
                    <a href='/users/{{$member->id}}'>
                        <img class="grid-image" src={{$member->image}}>
                        </br>
                        <h7>{{$member->name}}</h7>
                    </a>
                    @if(Auth::user()->ownerOfGroups()->find($group->id))
                        @if(Auth::user()->id != $member->id && $member->ownerOfGroups()->find($group->id))
                        <form method="post" action="{{route('unpromoteGroupOwner', $group->id)}}">
                        @csrf

                        <button class="grid-button" type="submit" ><p>Unromote Owner</p></button>
                        <input type="text" name="groupId" value="{{$group->id}}" hidden>
                        <input type="text" name="memberId" value="{{$member->id}}" hidden>
                        </form>
                        @elseif($member->ownerOfGroups()->find($group->id))
                        <button class="grid-button owner" ><p>Group Owner</p></button>
                        @else
                        <form method="post" action="{{route('promoteGroupOwner', $group->id)}}">
                        @csrf

                        <button class="grid-button" type="submit" ><p>Promote to owner</p></button>
                        <input type="text" name="groupId" value="{{$group->id}}" hidden>
                        <input type="text" name="memberId" value="{{$member->id}}" hidden>
                        </form>
                        @endif
                    @endif
                </li>
                @endforeach
            </ul>
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
                @endif
            @endif
        </div>
        <div class="posts">
            @include('partials.new_groupPost')
            @foreach ($group->posts as $post )
            @include('partials.post', ['post'=> $post])
            @endforeach
        </div>
    </div>
        
    
    
    </section>
@endsection