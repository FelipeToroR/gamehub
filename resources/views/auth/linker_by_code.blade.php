@extends('layouts.frontend.app')

@section('css')

@endsection

@section('content')

<div class="container pt-7">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
         <div class="card-header bg-white">
          <div class="text-muted text-center "><h4 class="p-0 m-0">{{$entrypoint->title ?? 'Bienvenido a GameHUB'}}</h4></div>
          <div class="text-muted text-center mb-1"><small>{{$entrypoint->information ??  'Has sido invitado a registrarte y disfrutar de una experiencia educativa'}}</small></div>
          </div> 
          <div class="card-body px-lg-5 py-lg-5">
            <div class="text-center text-muted mb-4">
                Para unirte a la experiencia educativa de «{{$entrypoint->experiment->name}}» <a href="{{route('register.code', $code)}}">registrate</a> si no tienes cuenta o <a href="{{route('login.code', $code)}}">inicia sesión</a> con tu cuenta existente.
              <hr class="mt-2 mb-3"/>
              <a href="{{route('register.code', $code)}}" class="btn btn-success btn-block ">Registrar una nueva cuenta</a>
              <a href="{{route('login.code', $code)}}" class="btn btn-warning btn-block">Iniciar sesión</a>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-6">
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('scripts')

@endpush

