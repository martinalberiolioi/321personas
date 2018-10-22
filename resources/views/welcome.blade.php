<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>321Personas</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="/css/welcome.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    321Personas
                </div>

                <div class="links">
                    <a href="http://127.0.0.1:8000/personas">Mostrar Personas</a>
                    <a href="http://127.0.0.1:8000/personas/create">Alta de Personas</a>
                </div>
            </div>
        </div>

        @if(!empty($mensaje))
            @php
                sleep(3);
            @endphp
            
            <script type='text/javascript'>alert('{{$mensaje}}');</script>
        @endif
    </body>
</html>
