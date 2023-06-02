@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
<div class="box box-primary">
  <div class="box-body">
      <div class="row">

<div class="col-lg-12">
  <h2>Modo de desarrollador</h2>
  <hr/>


  <h3>Encuestas asociadas</h3>
  <p>El experimento considera las siguientes encuestas:</p>
  <div class="table-responsive">
    <table class="table no-margin">
      <colgroup>
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 40%;">
        <col span="1" style="width: 40%;">
     </colgroup>
      <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
      </tr>
      </thead>
      <tbody>

        @foreach ($surveys_list as $survey)
        <tr>
          <td><a href="{{ route(
            'survey.run',
            [
                $experiment_id,
                $survey->id
            ]
        ) }}">{{ $survey->name }}</a></td>
          <td>{{ $survey->description }}</td>     
        </tr>
        @endforeach
    
      
      </tbody>
    </table>
  </div>
  


  <h3>Instancias de juego</h3>
  <p>El experimento considera las siguientes instancias de juego, balanceadas en base a la cantidad de usuarios:</p>

  <div class="table-responsive">
    <table class="table no-margin">
      <colgroup>
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 40%;">
        <col span="1" style="width: 40%;">
     </colgroup>
      <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Versión</th>
      </tr>
      </thead>
      <tbody>

        @foreach ($instances_list as $instance)
        <tr>
          <td><a href="{{ route(
            'game-instances.play',
            [
                $instance->game->slug,
                $instance->slug,
                't' => (new EncryptService())->encrypt_decrypt('encrypt', $instance->slug)
            ]
        ) }}">{{ $instance->name }}</a></td>
          <td>{{ $instance->game->description }}</td>
          <td>{{ $instance->description }}</td>     
        </tr>
        @endforeach
    
      
      </tbody>
    </table>
  </div>


</div>
      </div>
  </div>
</div>
    </div>
</div>

@endsection






