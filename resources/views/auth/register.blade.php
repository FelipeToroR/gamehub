<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GameHub | Registro de usuarios</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .login-page, .register-page {
            background: #3c8dbc;
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo" >
        <a href="{{ url('/home') }}">
            <img src="../assets/img/brand/logo.svg" style="height: 80px" />
        </a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Registrar nuevo usuario</p>

        <!--
        <form method="post" action="{{ url('/register') }}">
            @csrf

            <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombres">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('first_surname') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="first_surname" value="{{ old('first_surname') }}" placeholder="Apellido paterno">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('first_surname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_surname') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('second_surname') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="second_surname" value="{{ old('second_surname') }}" placeholder="Apellido materno (opcional)">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('second_surname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('second_surname') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback{{ $errors->has('gender') ? ' has-error' : '' }}">
                {!! Form::select('gender', array('M' => 'Masculino', 'F' => 'Femenino', 'U' => 'Prefiero no decirlo'), null, ['class' => 'form-control', 'placeholder' => 'Género']) !!}
                @if ($errors->has('second_surname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('second_surname') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('course') ? ' has-error' : '' }}">
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
                    ]), null, ['class' => 'form-control', 'placeholder' => 'Curso']) !!}
                @if ($errors->has('course'))
                    <span class="help-block">
                        <strong>{{ $errors->first('course') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('course_letter') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="course_letter" value="{{ old('course_letter') }}" placeholder="Letra del curso (opcional)">
                @if ($errors->has('course_letter'))
                    <span class="help-block">
                        <strong>{{ $errors->first('course_letter') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('college') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="college" value="{{ old('college') }}" placeholder="Colegio">
                @if ($errors->has('college'))
                    <span class="help-block">
                        <strong>{{ $errors->first('college') }}</strong>
                    </span>
                @endif
            </div>

            <hr/>

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Acepto los <a href="#">términos y condiciones</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    -->
    <p>Debes ser invitado para acceder a GameHUB</p>
        <a href="{{ url('/login') }}" class="text-center">Ya soy miembro, ¡quiero iniciar sesión!</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
