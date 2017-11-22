<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISCOOG</title>
    <script src="{{ url('/') }}/js/jquery.json"></script>
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('/') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ url('/') }}/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap-select.min.css">

    <script type="text/javascript">
        $('.itemName').select2({
          placeholder: 'Select an item',
          ajax: {
            url: '/select2-autocomplete-ajax',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.email,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
        });

    </script>

    <link href="{{ url('/') }}/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Styles -->

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
</head>
<body id="app-layout">
    <nav class="navbar navbar-custom navbar-static-top">
        <div class="container">
            <div class="navbar-header page-scroll">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button> 

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('/') }}/img/logo.png">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <!-- Authentication Links -->
                    @if(Auth::guard('admin')->user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php $nome = explode(" ", Auth::guard('admin')->user()->name); echo $nome[0]; ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                 <li><a href="{{ url('/admin/edit') }}"><i class="fa fa-btn fa-sign-out"></i>Atualizar dados</a></li>
                                <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::guard('user')->user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php $nome = explode(" ", Auth::guard('user')->user()->name); echo $nome[0]; ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/edit') }}"><i class="fa fa-btn fa-sign-out"></i>Atualizar dados</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">Login User</a></li>
                        <li><a href="{{ url('/admin/login') }}">Login Admin</a></li>
                        <li><a href="{{ url('/register') }}">Register User</a></li>
                        <li><a href="{{ url('/admin/register') }}">Register Admin</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
