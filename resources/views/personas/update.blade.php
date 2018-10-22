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
        <link rel="stylesheet" type="text/css" href="/css/update.css">
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
            <form action='http://127.0.0.1:8000/personas/{{$persona->id}}' method='POST'>  
                @csrf
                @method('PUT')
                <table>
                    <tr>
                        <td>Nombre</td>
                        <td><input type="text" name='nombre' value={{$persona->nombre}}></td>
                    </tr>
                    <tr>
                        <td>Apellido</td>
                        <td><input type="text" name='apellido' value={{$persona->apellido}}></td>
                    </tr>
                    <tr>
                        <td>Edad</td>
                        <td><input type="number" name='edad' value={{$persona->edad}}></td>
                    </tr>
                    <tr>
                        <td>DNI</td>
                        <td><input type="number" name='dni' value={{$persona->dni}} readonly></td>
                    </tr>
                    <tr>
                        <td>Legajo</td>
                        <td><input type="number" name='legajo' value={{$persona->legajo}} readonly></td>
                    </tr>
                    <tr>
                        <td>Puesto</td>
                        <td><input type="text" name='puesto' value={{$persona->puesto}}></td>
                    </tr>
                    <tr>
                        <td>Mail</td>
                        <td><input type="mail" name="mail" value={{$persona->mail}} readonly></td>
                    </tr>
                    <tr>
                        <td>Habilidad</td>
                        <td>
                            <select name="idSkill[]" multiple="multiple">
                                @foreach($skills as $skill)
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