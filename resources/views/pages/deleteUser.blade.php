@extends('layouts.app')

@section('title', $user->name)

@section('content')
<br>
    <section>
        <form method="post" action="{{route('deleteUser',$user->id)}}">
            <input type="hidden" name="_method" >
            {{csrf_field()}}
            <label> Are you sure you want to delete user {{$user->name}}</label>
            <button type='submit'> Delete</button>
        </form>
    </section>
@endsection
