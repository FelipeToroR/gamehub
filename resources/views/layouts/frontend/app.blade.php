<!DOCTYPE html>
<html lang="es">
<head>
  @include('layouts.frontend.components.header')
</head>
<body class="skin-gh landing-page">

  <!-- Navbar -->
  @include('layouts.frontend.components.navbar')

  @yield('player')
  <!-- End Navbar -->
  <section class="section section-hero bg-cloud">
    <div class="shape shape-style-3 shape-default">
    </div>
    <div class="page-header">
      @yield('content')
    </div>
  </section>

  @include('layouts.frontend.components.footer')

  <!-- Core JS Files   -->
  <script src="/assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
  <script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="/assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="/assets/js/plugins/moment.min.js"></script>
  <script src="/assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
  <script src="/assets/js/plugins/bootstrap-datepicker.min.js"></script>
  <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <!-- <script src="/assets/js/argon-design-system.min.js?v=1.2.0" type="text/javascript"></script> -->
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  
  <!-- Loading overlay -->
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  @stack('scripts')

</body>
</html>