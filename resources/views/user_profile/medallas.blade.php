
@extends('user_profile.user_profile')


@section('specific_content')




<div class="container fluid">
		<h1 class="text-center" style = "color: white;">Medallas y Experiencia</h1>
		<div class="row">
			<!-- Columna de medallas -->
			<div class="col-md-6">
				<h2 class="text-center mb-4" style = "color: white;">Mis Medallas</h2>
	
				
				<div class="row">
				@foreach ($userBadges as $badge)
				  @if ( $badge->deleted_at == NULL  && isset( $badge->gameBadge->id ) )
					<div class="col-md-4 mb-4">
						<div class="card" style="background-color: white;">
							<div class="card-body">
								<img src="{{url('public\images\medallas\medalla_' . $badge->gameBadge->id . '_' . $badge->gameBadge->code . '.png') }}"class="img-fluid" alt="medalla" style="border-radius: 60%;">
								<h5 class="card-title"  style="color: #212529;">{{ $badge->gameBadge->name }}</h5>
								<p class="card-text"  style="color: #212529;">Ganada el {{$badge->created_at->format('d/m/Y')}}</p>
							</div>
						</div>
					</div>
				  @endif
				@endforeach
				</div>
			</div>
			<!-- Columna de experiencia -->
			<div class="col-md-6">
				<h2 class="text-center mb-4" style = "color: white;">Mi Experiencia</h2>
				<div class="card" style="background-color: white;">
					<div class="card-body">
						<h5 class="card-title">Nivel actual: {{ $level }}</h5>
						<p class="card-text">Has ganado {{ $currentPoints }} puntos de experiencia</p>
						<div class="progress">
							<div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<p class="text-center mt-3">Te faltan {{ $nextLevelPoints - $currentPoints  }} puntos para llegar al siguiente nivel</p>
					</div>
				</div>
			</div>

@endsection
