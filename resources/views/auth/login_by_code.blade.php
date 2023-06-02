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
              <b>Inicia sesión y asocia un nuevo juego a tu cuenta</b>
            </div>
            <form role="form" method="post" action="{{ url('/login') }}">
                @csrf
              <input type="hidden" name="code" value="{{ $code }}" />
              <div class="form-group mb-3">
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative ">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                  </div>
                  <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico">
                </div>
                @if ($errors->has('email'))
                <p class="text-muted"><small>{{ $errors->first('email') }}</small></p>
                @endif
                </div>
              </div>
              <div class="form-group focused {{ $errors->has('password') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative has-feedback">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input type="password" class="form-control" placeholder="Contraseña" name="password">
                </div>
                @if ($errors->has('password'))
                <p class="text-muted"><small>{{ $errors->first('password') }}</small></p>
                </span>
                @endif
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-success my-4">Iniciar sesión</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-6">
            <a href="#" class="text-gray-dark"><small>¿Olvidó su contraseña?</small></a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('scripts')

@endpush

