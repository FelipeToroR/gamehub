@extends('layouts.app')

@section('content')

@foreach ($users as $user)
    
        <div> {{$user->name }} con ID instancia : {{$user->game_instance_id}}</div>
        <div></div>
        

    @endforeach

@endsection
