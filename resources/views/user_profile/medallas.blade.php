
@extends('user_profile.user_profile')


@section('specific_content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<div class="container fluid">
		<h1 class="text-center mb-6" style = "color: white;">Medallas y Experiencia</h1>
		<div class="row">
			<!-- Columna de medallas -->
			<div class="col-md-6">
				<h2 class="text-center mb-4" style = "color: white;">Mis Medallas</h2>
				<div class="row">
					<div class="col-md-4 mb-4">
						<div class="card">
							<div class="card-body">
								<img src="https://via.placeholder.com/150" class="img-fluid rounded-circle mb-2" alt="medalla">
								<h5 class="card-title">Medalla de Bronce</h5>
								<p class="card-text">Ganada el 23/04/2023</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-4">
						<div class="card">
							<div class="card-body">
								<img src="https://via.placeholder.com/150" class="img-fluid rounded-circle mb-2" alt="medalla">
								<h5 class="card-title">Medalla de Plata</h5>
								<p class="card-text">Ganada el 24/04/2023</p>
								<p class="card-text"><small class="text-muted">Expira en 3 días</small></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-4">
						<div class="card">
							<div class="card-body">
								<img src="https://via.placeholder.com/150" class="img-fluid rounded-circle mb-2" alt="medalla">
								<h5 class="card-title">Medalla de Oro</h5>
								<p class="card-text">Ganada el 25/04/2023</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Columna de experiencia -->
			<div class="col-md-6">
				<h2 class="text-center mb-4" style = "color: white;">Mi Experiencia</h2>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Nivel 7</h5>
						<p class="card-text">Has ganado 3,524 puntos de experiencia</p>
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<p class="text-center mt-3">Te faltan 476 puntos para llegar al siguiente nivel</p>
					</div>
				</div>
			</div>
		</div>
	</div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
