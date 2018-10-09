<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Personas</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: top;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .grid-container{
                display: grid;
                grid-template-columns: 10;
                grid-template-rows: @count($Personas);
                margin:0 auto;
                color: black;
                text-align:center;
            }

            .greenButton {
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                opacity: 0.6;
                transition: 0.3s;
            }

            .greenButton:hover {opacity: 1}

            .blueButton {
                background-color: #008CBA;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                opacity: 0.6;
                transition: 0.3s;
            }

            .blueButton:hover {opacity: 1}

            .grayButton {
                background-color: gray; 
                border: none;
                color: black;
                font-weight: bold;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                transition: 0.3s;
            }

            .grayButton:hover {
                background-color: #3e8e41;
                color: white;
            }

            .bottomPageButton {
                background-color: #baffe5;
                border: none;
                color: black;
                padding: 15px 15px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                opacity: 0.6;
                border-radius:8px;
                transition: 0.3s;
            }

            .bottomPageButton:hover {
                background-color: #3affb4;
                color:black;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="content">
                <div class="title">
                    Registro de personas
                </div>
            </div>
        </div>
        <a href='#pageBottom'>
            <button class="bottomPageButton" type="button">Ir al fondo</button>
        </a>
        <div class="grid-container">
            <form>
            @csrf
            @method('DELETE')
                <table>
                <thead>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>EDAD</th>
                    <th>DNI</th>
                    <th>LEGAJO</th>
                    <th>PUESTO</th>
                    <th>MAIL</th>
                    <th>HABILIDADES</th>
                </thead>
                <tbody>
                    @foreach($Personas as $persona)
                        <tr>
                            <td>{{$persona->id}}</td>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->apellido}}</td>
                            <td>{{$persona->edad}}</td>
                            <td>{{$persona->dni}}</td>
                            <td>{{$persona->legajo}}</td>
                            <td>{{$persona->puesto}}</td>
                            <td>{{$persona->mail}}</td>
                            <td>{{$persona->nombreSkills}}</td>
                            <td>
                                <a href='http://127.0.0.1:8000/personas/{{$persona->id}}/edit'>
                                <button class="greenButton" type="button">Modificar</button>
                                </a>
                            </td>
                            <td>
                                <button class="blueButton" formaction='http://127.0.0.1:8000/personas/{{$persona->id}}' formmethod="POST" type="submit" onclick="return confirm('¿Esta seguro que desea eliminar?')">Eliminar</button>
                            </td>
                         </tr> 
                    @endforeach             
                </tbody> 
                </table>
            </form>
        </div>

        <br>
        <a class="grayButton" href="http://127.0.0.1:8000/">Volver al inicio</a>
        <a name="pageBottom">
    </body>
</html>
