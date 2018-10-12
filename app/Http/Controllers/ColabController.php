<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColaboratorFormRequest;
use App\Http\Requests\ModificarColaboratorFormRequest;
use App\Rules\DoesColabExist;
use App\Rules\DoesSkillExist;
use App\Rules\DoesColabSkillExist;
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
        $personas = Colaborator::with(['ColabsSkills' => function($query){
            $query->leftJoin('skills','colabs_skills.skill_id','=','skills.id');
        }])->get();

        return view('personas/index')->with('personas', $personas);
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

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)

        //CAMBIAR
        $this->insertarColabsSkills($arraySkills,$colaborator->id);

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
        //
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

        $colaborator->nombre = ucfirst(trans(Input::get('txtNombre'))); //ucfirst(trans('algo')) convierte la primera letra del nombre y apellido a mayuscula
        $colaborator->apellido = ucfirst(trans(Input::get('txtApellido')));
        $colaborator->edad = Input::get('txtEdad');
        $colaborator->puesto = ucfirst(trans(Input::get('txtPuesto')));

        $colaborator->save();

        /*
         * Primero chequea que el campo este seleccionado. Porque el usuario podria no querer modificar la skill
         */

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)
        /*if($arraySkills){
            foreach ($arraySkills as $skill) {
                $colabs_skills = $Colaborator->ColabsSkills;
                foreach ($Colaborator->ColabsSkills as $ $colabsSkill) {
                    toArray()
                    inArray()
                }
            }
        }*/

        $todosColabSkills = ColabsSkills::all();

        if($arraySkills !== null)
        {
            $this->insertarColabsSkills($arraySkills, $colaborator->id);
        }

        $message = "Se modifico a la persona con exito!!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        //sleep(3);

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

    public function insertarColabsSkills($arraySkills, $idColaborator)
    {  
        /*
         * Por cada skill, crea una entrada de colab_id y skill_id en la base de datos
         */
        foreach($arraySkills as $unSkill){

            /*
             * Chequea si el combo colab_id y skill_id existen
             */
            $validador = ColabsSkills::where('colab_id','=',$idColaborator)
                            ->where('skill_id','=',$unSkill)
                            ->first();

            /*
             * Si el combo colab_id y skill_id NO existen, entonces los asigna
             *
             * Se crea una nueva instancia por cada iteracion porque sino, en vez de insertar, intenta hacer update y rompe
             */
            if(!($validador))
            {

                $colabSkill = new ColabsSkills();

                $colabSkill->skill_id = $unSkill;
                $colabSkill->colab_id = $idColaborator;

                $colabSkill->save();
            }       

        }
        
    }
}
