<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
    <div class="container">
        <a class="navbar-brand mr-lg-5" href="/">
        <img src="/assets/img/brand/logo.svg">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
        <div class="navbar-collapse-header">
            <div class="row">
            <div class="col-6 collapse-brand">
                <a href="/">
                <img src="/assets/img/brand/logo.svg">
                </a>
            </div>
            <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                </button>
            </div>
            </div>
        </div>
        @if (Auth::guest())
        <!-- Invitado -->
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            <li class="nav-item d-none d-lg-block ml-lg-4">
                <!-- <a href="#" target="_blank" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon">
                    <i class="fa fa-shopping-cart"></i>
                    </span>
                    <span class="nav-link-inner--text">Upgrade to PRO</span>
                </a> -->
                <a href="{{route('login')}}"  class="btn btn-white btn-icon">
                    <span class="btn-inner--icon">
                    <i class="fa fa-sign-in mr-2"></i>
                    </span>
                    <span class="nav-link-inner--text">INICIAR SESIÓN</span>
                </a>
            </li>
        </ul>
        @else
        <!-- Logueado -->
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            
            @hasrole('admin')
            <li class="nav-item">
            <a href="{{ route('experiments.index') }}" class="nav-link" role="button">
                <i class="ni ni-ui-04 d-lg-none"></i>
                <span class="nav-link-inner--text">Administración</span>
            </a>
            </li>
            @endrole

            @if(!Request::is('dashboard.index'))
            <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link" role="button">
                <i class="ni ni-ui-04 d-lg-none"></i>
                <span class="nav-link-inner--text">Mis juegos</span>
            </a>
            </li>
            @endif
            <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
                <i class="ni ni-ui-04 d-lg-none"></i>
                <span class="nav-link-inner--text">Mi sesión</span>
            </a>
   
            <div class="dropdown-menu dropdown-menu-xl">
                <div class="dropdown-menu-inner">
                <a href="#" disabled="disabled" class="media d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-info rounded-circle text-white">
                    <i class="fa fa-user"></i>
                    </div>
                    <div class="media-body ml-3">
                    <h6 class="heading text-primary mb-md-1">Mi Perfil</h6>
                    <p class="description d-none d-md-inline-block mb-0">Información de usuario</p>
                    </div>
                </a>
                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="media d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-danger rounded-circle text-white">
                    <i class="fa fa-times"></i>
                    </div>
                    <div class="media-body ml-3">
                    <h6 class="heading text-primary mb-md-1">Cerrar sesión</h6>
                    <p class="description d-none d-md-inline-block mb-0">Finaliza la sesión de usuario</p>
                    </div>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
                </div>
            </div>
            </li>

            <li class="nav-item dropdown">
            <!-- <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
                <i class="ni ni-collection d-lg-none"></i>
                <span class="nav-link-inner--text">Examples</span>
            </a> -->
            <div class="dropdown-menu">
                <a href="../examples/landing.html" class="dropdown-item">Landing</a>
                <a href="../examples/profile.html" class="dropdown-item">Profile</a>
                <a href="../examples/login.html" class="dropdown-item">Login</a>
                <a href="../examples/register.html" class="dropdown-item">Register</a>
            </div>
            </li>
        </ul>
        @endif
       
    </div>
</nav>