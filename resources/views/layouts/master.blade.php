<!DOCTYPE html>

<html
@if (App::isLocale('en'))
lang="en"
dir="ltr"
@elseif (App::isLocale('ar'))
lang="ar"
dir="rtl"
@endif
  class="light-style layout-navbar-fixed layout-menu-fixed"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Load Server @yield('title')</title>


    <!-- Favicon -->
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{  asset('assets/img/logo2.webp') }}" />


      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

<style>

*{
  font-family: "Cairo", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
  font-variation-settings:
    "slnt" 0;
}

</style>

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />



 @include('layouts.parts.styles')

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        @include('layouts.parts.menu')

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

         @include('layouts.parts.navbar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Content -->

            @yield('content')
            <!-- / Content -->
            </div>

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="py-2 footer-container d-flex align-items-center justify-content-between flex-md-row flex-column">
                  <div>
                    © made by Ahmed Nour
                </div>

                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

   @include('layouts.parts.scripts')
   @yield('script')
  </body>
</html>
