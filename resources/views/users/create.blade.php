@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Usuarios
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'users.store', 'class' => 'sidebar-form']) !!}
            @include('users.fields')
        {!! Form::close() !!}
    </div>
@endsection
