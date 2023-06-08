@canany(['home.index'])
<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="/home"><i class="fa fa-book"></i><span>Dashboard</span></a>
</li>
@endcan

@canany(['games.edit', 'games.create', 'games.destroy', 'games.index'])
<li class="{{ Request::is('games*') ? 'active' : '' }}">
    <a href="{{ route('games.index') }}"><i class="fa fa-gamepad"></i><span>Juegos</span></a>
</li>
@endcan


@canany(['game-exercises.create'])
<li class="{{ Request::is('gameExercises*') ? 'active' : '' }}">
    <a href="{{ route('gameExercises.index') }}"><i class="fa fa-edit"></i><span>Ejercicios</span></a>
</li>
@endcan

@canany(['experiments.create'])

<li class="{{ Request::is('experiments*') ? 'active' : '' }}">
    <a href="{{ route('experiments.index') }}"><i class="fa fa-edit"></i><span>Experimentos</span></a>
</li>

@endcan

@canany(['experiments.create'])
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i><span>Usuarios</span></a>
</li>
@endcan


<li class="{{ Request::is('rewards*') ? 'active' : '' }}">
    <a href="{{ route('rewards.index') }}"><i class="fa fa-money"></i><span>Recompensas</span></a>
</li>

<li class="{{ Request::is('bagItemTypes*') ? 'active' : '' }}">
    <a href="{{ route('bagItemTypes.index') }}"><i class="fa fa-circle-thin"></i><span>Objetos de mochila</span></a>
</li>

<li class="{{ Request::is('userBagItems*') ? 'active' : '' }}">
    <a href="{{ route('userBagItems.index') }}"><i class="fa fa-user-circle-o"></i><span>Objetos de mochila por usuario</span></a>
</li>

<li class="{{ Request::is('tiempo_x_instancias*') ? 'active' : '' }}">
    <a href="{{ route('tiempo_x_instancias.index') }}"><i class="fa fa-calendar"></i><span>Tiempo por Instancia</span></a>
</li>

<li class="{{ Request::is('rendimiento_grupos*') ? 'active' : '' }}">
    <a href="{{ route('rendimiento_grupos.index') }}"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Rendimiento por Grupos</span></a>
</li>



