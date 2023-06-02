@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Experimento
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información general</h3>
                      </div>
                    <div class="box-body">
                        <div class="row" style="padding-left: 20px">
                            @include('experiments.show_fields')
                            <a href="{{ route('experiments.index') }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Instancias del experimento</h3>
                      </div>
                    <div class="box-body">
                        <div class="row" style="padding-left: 20px">
                            <div class="alert alert-info">
                                Pronto ...
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <a href="{{ route('experiments.game-instances.index', $experiment->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-folder-open"></i> Ver todas las versiones de juego
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Encuestas activas</h3>
                      </div>
                    <div class="box-body">
                        <div class="row" style="padding-left: 20px">
                            <div class="alert alert-info">
                                Pronto ...
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <a href="{{ route('experiments.surveys.index', $experiment->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-list-alt"></i> Ver todas las encuestas activas
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usuarios asociados</h3>
                      </div>
                    <div class="box-body">
                        <div class="row" style="padding-left: 20px">
                            <div class="alert alert-info">
                                Pronto ...
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <a href="{{ route('experiments.users.index', $experiment->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-user"></i> Ver todos los usuarios asociados
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Entrypoints</h3>
                      </div>
                    <div class="box-body">
                        <div class="row" style="padding-left: 20px">
                            <div class="alert alert-info">
                                Pronto ...
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <a href="{{ route('experiments.entrypoints.index', $experiment->id) }}" class='btn btn-default'>
                            <i class="glyphicon glyphicon-user"></i> Ver todos los entrypoints
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reportes</h3>
                      </div>
                    <div class="box-body">
                        <div class="content" style="padding-left: 20px">
                            <a href="{{ route('experiments.reports.consolidated', $experiment->id) }}" target="_blank" class='btn btn-default btn-block btn-lg'>
                                <i class="fas fa-file-excel"></i> Generar reporte consolidado <i>(recomendado)</i>
                            </a>
                            <a href="{{ route('experiments.reports.tests', $experiment->id) }}" target="_blank" class='btn btn-default btn-block btn-lg'>
                                <i class="fas fa-file-excel"></i> Generar reporte de tests <i>(recomendado)</i>
                            </a>
                            <hr/>
                            <a href="{{ route('experiments.reports.summary', $experiment->id) }}" target="_blank" class='btn btn-default btn-block'>
                                <i class="glyphicon glyphicon-resize-small"></i> Resumen
                            </a>
                            <a href="{{ route('experiments.reports.performance', $experiment->id) }}" target="_blank" class='btn btn-default btn-block'>
                                <i class="glyphicon glyphicon-resize-small"></i> Rendimiento
                            </a>
                            <a href="{{ route('experiments.reports.time', $experiment->id) }}" target="_blank" class='btn btn-default btn-block'>
                                <i class="glyphicon glyphicon-resize-small"></i> Tiempo
                            </a>
                            
                        </div>
                    </div>
                   
                </div>
            </div>




            

            <div class="col-md-12">
                <!-- Submit Field -->
                <div class="form-group col-sm-12">
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>
            </div>
        </div>
    </div>
@endsection
