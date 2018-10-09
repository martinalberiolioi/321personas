<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColaboratorFormRequest;
use App\Http\Requests\ModificarColaboratorFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ColabsSkills;
use App\Colaborator;

class colabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Joinea "colaboradores" con "colabs_skills". Ahi recupera los colaboradores y, para los que tienen, el skill_id.
         * Despues, joinea "colabs_skills" con "skills"
         * Despues hace un select para elegir TODAS las columnas de colaboradores y SOLAMENTE los nombres de los skills        
         */
        $Personas = DB::table('colaborators')
                        ->leftJoin('colabs_skills', 'colaborators.id', '=', 'colabs_skills.colab_id')
                        ->leftjoin('skills', 'skills.id', '=', 'colabs_skills.skill_id')
                        ->select('colaborators.id',
                            'colaborators.nombre',
                            'colaborators.apellido',
                            'colaborators.edad',
                            'colaborators.dni',
                            'colaborators.legajo',
                            'colaborators.puesto',
                            'colaborators.mail',
                            'skills.nombre AS nombreSkills')
                        ->whereNull('deleted_at')  
                        ->orderBy('colaborators.id','asc')
                        ->get();

        /**
         * Recorre todo el array de Personas
         * Agarra una persona y va comparando por ID con el resto de las entradas
         * Si encuentra un ID igual, significa que hay dos entradas de la misma persona con dos habilidades distintas
         * Entonces, toma la habilidad del repetido y la concatena con la entrada original
         */
        for($i = 0; $i < count($Personas); $i++){
            for($k = $i+1; $k < count($Personas); $k++){

                if($Personas[$i]->id == $Personas[$k]->id){

                    $auxiliar = $Personas[$i]->nombreSkills;
                    $Personas[$i]->nombreSkills = $auxiliar.', '.$Personas[$k]->nombreSkills;
                }
            }
        }

        /**
         *  Una vez que todas las personas tienen todas las habilidades asignadas, crea un nuevo array SIN entradas pepetidas (Si habia dos ID iguales, deja uno solo)
         */
        $PersonasFiltradas = $Personas->unique('id');

        return view('personas/index')->with('Personas', $PersonasFiltradas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Skills = DB::table('skills')
                        ->select('id','nombre')
                        ->orderBy('nombre','asc')
                        ->get();
        return view('personas/create')->with('Skills', $Skills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColaboratorFormRequest $request)
    {        
        $colaborator = new Colaborator();

        //ucfirst(trans('algo')) convierte la primera letra del nombre y apellido a mayuscula
        $colaborator->nombre = ucfirst(trans(Input::get('txtNombre')));
        $colaborator->apellido = ucfirst(trans(Input::get('txtApellido')));
        //
        $colaborator->edad = Input::get('txtEdad');
        $colaborator->dni = Input::get('txtDni');
        $colaborator->legajo = Input::get('txtLegajo');
        $colaborator->puesto = ucfirst(trans(Input::get('txtPuesto')));
        $colaborator->mail = Input::get('txtMail');

        $colaborator->save();

        //esta linea de codigo cuenta (count()) la cantidad de entradas en la tabla. Esta cantidad es igual al ID de la ultima entrada de la tabla, entonces recupera el ID para pasarlo a colabs_skills
        $idColab = count(DB::table('colaborators')
                        ->select('*')
                        ->get());
        //

        var_dump($idColab);
        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)       

        /**
         * Por cada skill, crea una entrada de colab_id y skill_id en la base de datos
         */
        foreach($arraySkills as $unSkill){

            /*
             * Chequea si el combo colab_id y skill_id existen
             */
            $validador = ColabsSkills::where('colab_id','=',$idColab)
                            ->where('skill_id','=',$unSkill)
                            ->first();

            /*
             * Si el combo colab_id y skill_id NO existen, entonces los asigna
             * Se crea una nueva instancia por cada iteracion porque sino, en vez de insertar, intenta hacer update y rompe
             */
            if(!($validador)){

                $colabSkill = new ColabsSkills();

                $colabSkill->skill_id = $unSkill;
                $colabSkill->colab_id = $idColab;

                $colabSkill->save();
            }
            
        }

        $message = "Se agrego a la persona con exito!!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        sleep(3);

        return view('welcome'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //asdasdas
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $Skills = DB::table('skills')
                        ->select('id','nombre')
                        ->orderBy('nombre','asc')
                        ->get();

        $Persona = DB::table('colaborators')
                        ->select('id','nombre','apellido','edad','dni','legajo','puesto','mail')
                        ->where('id','=',$id)
                        ->get();

        return view('personas/update')->with(['Skills'=> $Skills,'Persona' => $Persona]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModificarColaboratorFormRequest $request, $id)
    {
        $colaborator = Colaborator::find($id);

        //ucfirst(trans('algo')) convierte la primera letra del nombre y apellido a mayuscula
        $colaborator->nombre = ucfirst(trans(Input::get('txtNombre')));
        $colaborator->apellido = ucfirst(trans(Input::get('txtApellido')));
        //
        $colaborator->edad = Input::get('txtEdad');
        $colaborator->puesto = ucfirst(trans(Input::get('txtPuesto')));

        $colaborator->save();

        /*
         * Primero chequea que el campo este seleccionado. Porque el usuario podria no querer modificar la skill
         */
        if($request->input('idSkill') !== null){

            $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)       
            $idColab = $colaborator->id;

            /*
             * Por cada skill, crea una entrada de colab_id y skill_id en la base de datos
             */
            foreach($arraySkills as $unSkill){

                /*
                 * Chequea si el combo colab_id y skill_id existen
                 */
                $validador = ColabsSkills::where('colab_id','=',$idColab)
                                ->where('skill_id','=',$unSkill)
                                ->first();

                /*
                 * Si el combo colab_id y skill_id NO existen, entonces los asigna
                 *
                 * Se crea una nueva instancia por cada iteracion porque sino, en vez de insertar, intenta hacer update y rompe
                 */
                if(!($validador)){

                    $colabSkill = new ColabsSkills();

                    $colabSkill->skill_id = $unSkill;
                    $colabSkill->colab_id = $idColab;

                    $colabSkill->save();
                }
                

            }
        
        }

        $message = "Se modifico a la persona con exito!!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        sleep(3);

        return view('welcome');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colaborator = Colaborator::find($id);
        $colaborator->delete();

        $message = "Se elimino a la persona con exito!!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        sleep(3);

        return view('welcome');
    }
}
