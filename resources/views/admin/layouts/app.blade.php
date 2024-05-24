<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin-assects/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin-assects/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin-assects/vendor/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('admin-assects/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assects/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assects/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assects/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assects/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-assects/dropzone/min/dropzone.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('admin-assects/vendor/simple-datatables/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('admin-assects/css/select2.min.css') }} " rel="stylesheet">
    <link href="{{ asset('admin-assects/summernote/summernote.css') }} " rel="stylesheet">
    <link href="{{ asset('admin-assects/datetime/datetimepicker.css') }} " rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('admin-assects/css/style.css') }} " rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('admin.layouts.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('admin.layouts.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        @yield('main_content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('admin-assects/vendor/apexcharts/apexcharts.min.js') }} "></script>
    <script src="{{ asset('admin-assects/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assects/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin-assects/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('admin-assects/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('admin-assects/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assects/dropzone/min/dropzone.min.js') }}"></script>
    {{-- <script src="{{ asset('admin-assects/vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
    <script src="{{ asset('admin-assects/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin-assects/vendor/php-email-form/validate.js') }}"></script>
    <!-- jQuery CDN -->

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('script_add')
    <!-- Template Main JS File -->

    <script src="{{ asset('admin-assects/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin-assects/summernote/summernote.js') }}"></script>
    <script src="{{ asset('admin-assects/datetime/datetimepicker.js') }}"></script>
    <script src="{{ asset('admin-assects/js/main.js') }}"></script>    
    <script>
   $(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
});
    </script>


</body>

</html>
