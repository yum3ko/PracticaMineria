<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link rel="shortcut icon" href="fassets/images/favicon.ico" type="image/png">

  <title>@yield('titulo')</title>

  <link href="fassets/css/jquery.datatables.css" rel="stylesheet">
  <link href="fassets/css/bootstrap.min.css" rel="stylesheet">
  

</head>

<body >

<section>


  <div class="mainpanel">

    <div class="pageheader">

       @yield('header')

    </div>


      <div class="contentpanel">
          @yield('contenido')
      </div>

  </div><!-- mainpanel -->
    @yield('footer')



</section>

<script src="{{ asset('fassets/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('fassets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('fassets/js/modernizr.min.js') }}"></script>
@yield('scripts')

</body>
</html>
