<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>
  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('backend/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('backend/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/vendor/css/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/vendor/libs/apex-charts/apex-charts.css') }}" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

  <style>
    .toast {
      z-index: 9999 !important;
    }
    .fl-wrapper {
      z-index: 9999 !important;
    }
  </style>

  <!-- Helpers & Config -->
  <script src="{{ asset('backend/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('backend/js/config.js') }}"></script>
</head>

<body>
  <!-- Layout Wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('backend.components.sidebar')

      <!-- Layout Page -->
      <div class="layout-page">
        @include('backend.components.header')

        <!-- Content Wrapper -->
        <div class="content-wrapper mt-3">
          @yield('backend')
          @include('backend.components.footer')
        </div>
      </div>
    </div>
  </div>

  <!-- 🚀 Flash Messages (Positioned outside the layout wrapper for proper z-index) -->
  @if (session('success'))
      <div class="alert alert-success position-fixed top-0 end-0 m-4" style="z-index: 999999999;">
          {{ session('success') }}
      </div>
  @endif

  @if (session('error'))
      <div class="alert alert-danger position-fixed top-0 end-0 m-4" style="z-index: 999999999;">
          {{ session('error') }}
      </div>
  @endif

  @if (session('warning'))
      <div class="alert alert-warning position-fixed top-0 end-0 m-4" style="z-index: 999999999;">
          {{ session('warning') }}
      </div>
  @endif

  @if (session('info'))
      <div class="alert alert-info position-fixed top-0 end-0 m-4" style="z-index: 999999999;">
          {{ session('info') }}
      </div>
  @endif

  <!-- Core JS -->
  <script src="{{ asset('backend/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('backend/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('backend/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('backend/vendor/js/menu.js') }}"></script>

  <!-- Vendors JS -->
  <script src="{{ asset('backend/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('backend/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('backend/js/dashboards-analytics.js') }}"></script>

  <!-- GitHub Buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    toastr.options = {
      "positionClass": "toast-top-right",
      "timeOut": "3000"
    };

    @if(session('success'))
      toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
      toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
      toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
      toastr.info("{{ session('info') }}");
    @endif
  </script>
<!-- Dispatch Attachment handeling and select user list  -->

</body>
</html>
