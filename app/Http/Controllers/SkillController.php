<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ColabsSkills;
Use App\Http\Requests\SkillFormRequest;

class skillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                        
        $Colabs = DB::table('colaborators')
                            ->select('id','nombre','apellido')
                            ->orderBy('nombre', 'asc')
                            ->get();
        return view('habilidades/create')->with(['Skills' => $Skills, 'Colabs' => $Colabs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillFormRequest $request)
    {        
        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)       
        $idColab = Input::get('idColab');

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

            /**
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

        $message = "Se registro habilidad con exito!!";
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
