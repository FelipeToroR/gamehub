@extends('layouts.frontend.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="card">
                    <div class="card-header">
                        Verifica tu dirección de correo electrónico
                    </div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">Se ha enviado un link para actualizar su correo electrónico.
                            </div>
                        @endif
                        <p>Antes de continuar, por favor comprueba el mail con el link de verificación. Si no has recibido este mail,</p>
                        <form  method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block m-0 mb-2">
                                Solicitar otro link de verificación
                            </button>
                        </form>
                    <a class="btn btn-block btn-secondary" href="{{ route('dashboard.index') }}">Verificar más tarde</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection