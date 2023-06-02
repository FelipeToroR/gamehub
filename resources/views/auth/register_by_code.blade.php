@extends('layouts.frontend.app')

@section('css')

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card bg-secondary shadow border-0">
          <div class="card-header bg-white pb-3">
          <div class="text-muted text-center "><h4>{{$entrypoint->title ?? 'Bienvenido a GameHUB'}}</h4></div>
            <div class="text-muted text-center mb-1"><small>{{$entrypoint->information ??  'Has sido invitado a registrarte y disfrutar de una experiencia educativa'}}</small></div>

          </div> 
          <div class="card-body px-lg-5 py-lg-3">
           
            <form method="post" action="{{ url('/register?code='.$entrypoint->token) }}">
                @csrf

                <input type="hidden" name="token" value="{{$entrypoint->token}}" />
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted"><b>Datos personales</b></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group has-feedback{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombres">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group has-feedback{{ $errors->has('first_surname') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="first_surname" value="{{ old('first_surname') }}" placeholder="Apellido paterno">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            
                            @if ($errors->has('first_surname'))
                                <span class="help-block">
                                    <small class="text-danger">{{ $errors->first('first_surname') }}</small>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group has-feedback{{ $errors->has('second_surname') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="second_surname" value="{{ old('second_surname') }}" placeholder="Apellido materno (opcional)">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            
                            @if ($errors->has('second_surname'))
                                <span class="help-block">
                                    <small class="text-danger">{{ $errors->first('second_surname') }}</small>
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group has-feedback{{ $errors->has('gender') ? ' has-danger' : '' }}">
                            {!! Form::select('gender', array('M' => 'Masculino', 'F' => 'Femenino', 'U' => 'Prefiero no decirlo'), null, ['class' => 'form-control', 'placeholder' => 'Género']) !!}
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <small class="text-danger">{{ $errors->first('gender') }}</small>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p class="text-muted"><b>Estudios</b></p>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group has-feedback{{ $errors->has('course') ? ' has-danger' : '' }}">
                        {!! Form::select('course', array(
                            'Enseñanza básica' => [
                                'PRIMERO BÁSICO' => '1° básico',
                                'SEGUNDO BÁSICO' => '2° básico',
                                'TERCERO BÁSICO' => '3° básico',
                                'CUARTO BÁSICO' => '4° básico',
                                'QUINTO BÁSICO' => '5° básico',
                                'SEXTO BÁSICO' => '6° básico',
                                'SEPTIMO BÁSICO' => '7° básico',
                                'OCTAVO BÁSICO' => '8° básico',
                            ]), old('default_course', $entrypoint->default_course), ['class' => 'form-control', 'placeholder' => 'Curso']) !!}
        
                        @if ($errors->has('course'))
                            <span class="help-block">
                                <small class="text-danger">{{ $errors->first('course') }}</small>
                            </span>
                        @endif
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group has-feedback{{ $errors->has('course_letter') ? ' has-danger' : '' }}">
                        <input type="text" class="form-control" name="course_letter" value="{{ old('course_letter') }}" placeholder="Letra del curso (opcional)">
                        @if ($errors->has('course_letter'))
                            <span class="help-block">
                                <small class="text-danger">{{ $errors->first('course_letter') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group has-feedback{{ $errors->has('college') ? ' has-danger' : '' }}">
                        <input type="text" class="form-control" name="college" value="{{ old('default_college', $entrypoint->default_college) }}" placeholder="Colegio">
                        @if ($errors->has('college'))
                            <span class="help-block">
                                <small class="text-danger">{{ $errors->first('college') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <p class="text-muted"><b>Cuenta de usuario</b></p>
                </div>


                <div class="col-lg-12">
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </span>
                    @endif
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </span>
                    @endif
                </div>
                </div>
                <div class="col-lg-6">
    
                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                        </span>
                    @endif
                </div>
                </div>
                <div class="col-lg-12">
                    <hr/>
                </div>
                <div class="col-lg-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Acepto los <a href="#">términos y condiciones</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                </div>
                <!-- /.col -->
                

            </div><!-- end row -->


                
    
    
               
    
                
    
                
    
               
    
                
            </form>
    
          </div>
        </div>
        <div class="row mt-3">
            <a href="{{ url('/login') }}" class="text-center">Ya soy miembro, ¡quiero iniciar sesión!</a>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('scripts')

@endpush

