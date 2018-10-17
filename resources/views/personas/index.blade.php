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
        <link rel="stylesheet" type="text/css" href="/css/index.css">
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
                    @foreach($personas as $persona)
                        <tr>
                            <td>{{$persona->id}}</td>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->apellido}}</td>
                            <td>{{$persona->edad}}</td>
                            <td>{{$persona->dni}}</td>
                            <td>{{$persona->legajo}}</td>
                            <td>{{$persona->puesto}}</td>
                            <td>{{$persona->mail}}</td>

                            @php
                                $allSkills = "";

                                foreach($persona->ColabsSkills as $colabskill)
                                {
                                       if($allSkills === "")
                                       {
                                            $allSkills .= $colabskill->nombre;
                                       }
                                       else
                                       {
                                           $allSkills .= ', '.$colabskill->nombre;
                                       }                                                                

                                }

                                if($allSkills === "")
                                {
                                    $allSkills = "sin habilidades";
                                }

                            @endphp
                           
                            <td>{{$allSkills}}</td>

                            
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
