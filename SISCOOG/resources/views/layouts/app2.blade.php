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
<body>
    @yield('content')

    <!-- JavaScripts -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
