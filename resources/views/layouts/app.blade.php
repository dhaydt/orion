<!DOCTYPE html>
<html lang="en">

<head>
  @include('layouts.partials._head')
</head>

<body class="d-flex justify-content-center">
  <div class="loading-wrapper">
    <img src="{{ asset('images/loading.gif') }}" height="100%" alt="">
  </div>
  <div class="main-container">
    @include('layouts.partials._header')
    <div class="container content-wrapper">
      @yield('content')
    </div>
  </div>

  @include('layouts.partials._foot')
</body>

</html>