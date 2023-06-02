<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <title>
    GameHUB — Plataforma educativa para estudiantes
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/argon-design-system.css?v=1.2.0" rel="stylesheet" />

<style>
.login-page, .register-page {
    background: #3c8dbc;
}

.section-shaped .shape-default {
    background: linear-gradient(150deg, #3c8dbc 15%, #03A9F4 70%);
}

  </style>



</head>

<body class="landing-page">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">

    <div class="container">
      <a class="navbar-brand mr-lg-5" href="../index.html">
        <img src="../assets/img/brand/logo.svg">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbar_global">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="../../../index.html">
                <img src="../assets/img/brand/blue.png">
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
        <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
          <li class="nav-item dropdown">
            <!--
            <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
              <i class="ni ni-ui-04 d-lg-none"></i>
              <span class="nav-link-inner--text">Components</span>
            </a>
          -->
            <div class="dropdown-menu dropdown-menu-xl">
              <div class="dropdown-menu-inner">
                <a href="https://demos.creative-tim.com/argon-design-system/docs/getting-started/overview.html" class="media d-flex align-items-center">
                  <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                    <i class="ni ni-spaceship"></i>
                  </div>
                  <div class="media-body ml-3">
                    <h6 class="heading text-primary mb-md-1">Crea una cuenta</h6>
                    <p class="description d-none d-md-inline-block mb-0">Crea una cuenta para jugar en la nueva plataforma asistido trabaja con tus compañeros</p>
                  </div>
                </a>
                <a href="https://demos.creative-tim.com/argon-design-system/docs/foundation/colors.html" class="media d-flex align-items-center">
                  <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                    <i class="ni ni-palette"></i>
                  </div>
                  <div class="media-body ml-3">
                    <h6 class="heading text-primary mb-md-1">Accede con tu cuenta</h6>
                    <p class="description d-none d-md-inline-block mb-0">¿Ya tienes cuenta? Entonces puedes iniciar sesión con tus datos</p>
                  </div>
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
        <div class="navbar-nav align-items-lg-center ml-lg-auto">
      
          
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper">
    <div class="section section-hero section-shaped">
      <div class="shape shape-style-3 shape-default">

      </div>
      <div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
          <div class="col px-0">
            <div class="row align-items-center justify-content-center">
              
              @if (!Auth::guest())
                <div class="col-lg-6 text-center">
                  <h1 class="text-white display-3">¡Hola {{ Auth::user()->name }}!</h1>
                  <h2 class="display-4 font-weight-normal text-white"><small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small></h2>
                  <div class="btn-wrapper mt-4">
                    <a href="{{ url('/logout') }}" class="btn btn-warning btn-icon mt-3 mb-sm-0"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="btn-inner--icon"><i class="fas fa-address-book"></i></span>
                    <span class="btn-inner--text">Cerrar sesión</span>
                </a>
                <a href="{{ url('/home') }}" class="btn btn-default btn-icon mt-3 mb-sm-0">
                  <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                  <span class="btn-inner--text">Ir al menú</span>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>       



                  </div>
                </div>
              @else
                <div class="col-lg-6 text-center">
                  <h2 class="text-white display-4">¡Inicia sesión y comienza a jugar!</h2>
                  <div class="btn-wrapper mt-4">
                    <!--
                    <a href="{{ url('/register') }}" disabled="disabled" class="btn btn-warning btn-icon mt-3 mb-sm-0">
                      <span class="btn-inner--icon"><i class="fas fa-address-book"></i></span>
                      <span class="btn-inner--text">Registrate</span>
                    </a>
                    -->

                    <a href="{{ url('/login') }}" class="btn btn-default btn-icon mt-3 mb-sm-0">
                      <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                      <span class="btn-inner--text">Iniciar sesión</span>
                    </a>
                  </div>
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    
    <div class="section" style="background-image: url('./assets/img/ill/1.svg');">
      <div class="container py-md">
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-6 mb-lg-auto">
            <div class="rounded overflow-hidden transform-perspective-left">
              <div id="carousel_example" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel_example" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel_example" data-slide-to="1" class=""></li>
                  <li data-target="#carousel_example" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="./assets/img/theme/img-1-1200x1000.jpg" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="./assets/img/theme/img-2-1200x1000.jpg" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="./assets/img/theme/img-1-1200x1000.jpg" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel_example" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel_example" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-5 mb-5 mb-lg-0">
            <h1 class="font-weight-light">Experiencias educativas en colegios</h1>
            <p class="lead mt-4">¡Ejercita, refuerza y aprende con juegos educativos! Decenas de experiencias en establecimientos educativos en la V región.</p>
            <a href="{{ url('/register') }}" class="btn btn-white mt-4">Registrate ahora</a>
          </div>
        </div>
      </div>
    </div>

    <br /><br />
    <footer class="footer">
      <div class="container">
        <div class="row row-grid align-items-center mb-5">
          <div class="col-lg-6">
            <h3 class="text-primary font-weight-light mb-2">Impulsado por</h3>
            <h4 class="mb-0 font-weight-light">Grupo de Investigación de Software y Juegos Educativos</h4>
          </div>
          <div class="col-lg-6 text-lg-center btn-wrapper">
            <img src="\public\assets\img\brand\pucv-logos.png" class="img-responsive" style="max-width: 450px" />
          </div>
        </div>
        <hr>
        <div class="row align-items-center justify-content-md-between">
          <div class="col-md-6">
            <div class="copyright">
              &copy; 2020 <a href="" target="_blank">PUCV</a>.
            </div>
          </div>
          <div class="col-md-6">
            <ul class="nav nav-footer justify-content-end">
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">Terminos y condiciones</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">Acerca de nosotros</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">Licencia</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="../assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <script src="../assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/bootstrap-datepicker.min.js"></script>
  <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <script src="../assets/js/argon-design-system.min.js?v=1.2.0" type="text/javascript"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>

  <script>

    (function() {
      // CODELAB: Register service worker.
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator.serviceWorker.register('/service-worker.js')
              .then((reg) => {
                console.log('Service worker registered.', reg);
              });
        });
      }
    })();
    
      </script>
</body>

</html>