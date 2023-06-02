

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Información personal</h3>
              </div>
            <div class="box-body">
                <div class="row">
                    <!-- Name Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'Nombre:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
        
                    <!-- Gender Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('gender', 'Género:') !!}
                        {!! Form::select('gender', array('1' => 'Masculino', '2' => 'Femenino'), null, ['class' => 'form-control', 'placeholder' => '']) !!}
                    </div>

                    <!-- First surname Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('first_surname', 'Apellido paterno:') !!}
                        {!! Form::text('first_surname', null, ['class' => 'form-control']) !!}
                    </div>
        
                    <!-- Second surname Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('second_surname', 'Apellido materno:') !!}
                        {!! Form::text('second_surname', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('user_roles', 'Roles:') !!}
                        {!! Form::select('user_roles',$role_items,$role_user_items,array('multiple'=>'multiple','name'=>'user_roles[]', 'class' => 'form-control')) !!}
                    </div>
        
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Información de colegio</h3>
              </div>
            <div class="box-body">
                <div class="row">
                    <!-- College Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('college', 'Colegio:') !!}
                        {!! Form::text('college', null, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Password Field -->
                    <div class="form-group col-sm-8">
                        {!! Form::label('course', 'Curso:') !!}
                        {!! Form::text('course', null, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Password Field -->
                    <div class="form-group col-sm-4">
                        {!! Form::label('course_letter', 'Letra de curso:') !!}
                        {!! Form::text('course_letter', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Información de cuenta</h3>
              </div>
            <div class="box-body">
                <div class="row">
                    <!-- Email Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('email', 'Correo electrónico:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Password Field -->
                    <div class="form-group col-sm-8">
                        {!! Form::label('password', 'Contraseña:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <!-- Password Field -->
                    <div class="form-group col-sm-8">
                        {!! Form::label('password_confirmation', 'Confirma tu contraseña:') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('users.index') }}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</div>




