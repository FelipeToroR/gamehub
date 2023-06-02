@extends('layouts.frontend.app')

@section('css')

@endsection

@section('content')

<div class="container pt-7">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
          <!-- <div class="card-header bg-white pb-5">
            <div class="text-muted text-center mb-3"><small>Sign in with</small></div>
            <div class="btn-wrapper text-center">
              <a href="#" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon"><img src="../assets/img/icons/common/github.svg"></span>
                <span class="btn-inner--text">Github</span>
              </a>
              <a href="#" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon"><img src="../assets/img/icons/common/google.svg"></span>
                <span class="btn-inner--text">Google</span>
              </a>
            </div>
          </div> -->
          <div class="card-body px-lg-5 py-lg-5">
            <div class="text-center text-muted mb-4">
              <b>Inicia sesión con tu cuenta</b>
            </div>
            <form role="form" method="post" action="{{ url('/login') }}">
                @csrf
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
              <!-- <div class="custom-control custom-control-alternative custom-checkbox">
                <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                <label class="custom-control-label" for=" customCheckLogin"><span>Remember me</span></label>
              </div> -->
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
          <!-- <div class="col-6 text-right">
            <a href="#" class="text-gray-dark"><small>Crear nueva cuenta</small></a>
          </div> -->
        </div>
      </div>
    </div>
  </div>

@endsection


@push('scripts')

@endpush

