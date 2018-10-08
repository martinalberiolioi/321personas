<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Modificar persona</title>

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

            form{
                display:grid;
                grid-template-columns: 2;
                grid-template-rows: 7;
                color: black;
                text-align:center;
                margin:5% 40%;
            }

            select{
                width:183px;
            }

            .grayButton {
                background-color: #aef9c6; 
                border: none;
                color: black;
                font-weight: bold;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                opacity: 0.6;
                transition: 0.3s;
            }

            .grayButton:hover {
                background-color: #3e8e41;
                color: white;
            }

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

        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="content">
                <div class="title">
                    Modificar Persona
                </div>
            </div>
        </div>

        <div>
            <form action='http://127.0.0.1:8000/personas/{{$Persona[0]->id}}' method='POST'>  
                @csrf
                @method('PUT')
                <table>
                    <tr>
                        <td>Nombre</td>
                        <td><input type="text" name='txtNombre' value={{$Persona[0]->nombre}}></td>
                    </tr>
                    <tr>
                        <td>Apellido</td>
                        <td><input type="text" name='txtApellido' value={{$Persona[0]->apellido}}></td>
                    </tr>
                    <tr>
                        <td>Edad</td>
                        <td><input type="number" name='txtEdad' value={{$Persona[0]->edad}}></td>
                    </tr>
                    <tr>
                        <td>DNI</td>
                        <td><div>{{$Persona[0]->dni}}</div></td>
                    </tr>
                    <tr>
                        <td>Legajo</td>
                        <td><div>{{$Persona[0]->legajo}}</div></td>
                    </tr>
                    <tr>
                        <td>Puesto</td>
                        <td><input type="text" name='txtPuesto' value={{$Persona[0]->puesto}}></td>
                    </tr>
                    <tr>
                        <td>Mail</td>
                        <td><div>{{$Persona[0]->mail}}</div></td>
                    </tr>
                    <tr>
                        <td>Habilidad</td>
                        <td>
                            <select name="idSkill[]" multiple="multiple">
                                @foreach($Skills as $skill)
                                    <option value={{$skill->id}}> {{$skill->nombre}} </option>
                                @endforeach       
                            </select>
                        </td>
                    </tr>
                </table>

                <button class="blueButton" type="submit" name="btnEnviar">Enviar</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif           
        </div>
        <br>
        <a class="grayButton" href="http://127.0.0.1:8000/">Volver al inicio</a>
    </body>
</html>