<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColaboratorFormRequest;
use App\Http\Requests\ModificarColaboratorFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ColabsSkills;
use App\Skill;
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
        $personas = Colaborator::with(['ColabsSkills' => function($query)
        {
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
        $skills = Skill::orderBy('nombre','asc')->get();
                        
        return view('personas/create')->with('skills', $skills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColaboratorFormRequest $request)
    {        

        $idColaborator = Colaborator::agregarUsuario(
            ucfirst(trans(Input::get('nombre'))), 
            ucfirst(trans(Input::get('apellido'))), 
            Input::get('edad'), 
            Input::get('dni'), 
            Input::get('legajo'), 
            ucfirst(trans(Input::get('puesto'))), 
            Input::get('mail')
        );

        //Colaborator::create($request->all()); //fue borrado porque tambien recupera el idSkill y no puede meter eso en colaborators

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)

        Colaborator::agregarSkills($arraySkills, $idColaborator);

        return view('welcome')->with('message','Se agrego a la persona con exito!!'); 
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
        $skills = Skill::orderBy('nombre','asc')->get();

        $persona = Colaborator::where('id','=',$id)->get();

        return view('personas/update')->with(['skills'=> $skills,'persona' => $persona]);
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

        Colaborator::modificarUsuario(
            $id,
            ucfirst(trans(Input::get('nombre'))),
            ucfirst(trans(Input::get('apellido'))),
            Input::get('edad'),
            ucfirst(trans(Input::get('puesto')))
        );

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)

        if($arraySkills)
        {
            Colaborator::agregarSkills($arraySkills, $id);
        }

        return view('welcome')->with('message', 'Se modifico a la persona con exito!!');
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

        return view('welcome')->with('message', 'Se elimino a la persona con exito!!');
    }

}
