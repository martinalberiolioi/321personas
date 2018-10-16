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
        $skills = DB::table('skills')
                        ->select('id','nombre')
                        ->orderBy('nombre','asc')
                        ->get();
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
            ucfirst(trans(Input::get('txtNombre'))), 
            ucfirst(trans(Input::get('txtApellido'))), 
            Input::get('txtEdad'), 
            Input::get('txtDni'), 
            Input::get('txtLegajo'), 
            ucfirst(trans(Input::get('txtPuesto'))), 
            Input::get('txtMail')
        );

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)

        Colaborator::agregarSkills($arraySkills, $idColaborator);

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
        $skills = DB::table('skills')
                        ->select('id','nombre')
                        ->orderBy('nombre','asc')
                        ->get();

        $persona = DB::table('colaborators')
                        ->select('id','nombre','apellido','edad','dni','legajo','puesto','mail')
                        ->where('id','=',$id)
                        ->get();

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

        $idColaborator = Colaborator::modificarUsuario(
            $id,
            ucfirst(trans(Input::get('txtNombre'))),
            ucfirst(trans(Input::get('txtApellido'))),
            Input::get('txtEdad'),
            ucfirst(trans(Input::get('txtPuesto')))
        );

        $arraySkills = $request->input('idSkill'); //recupera el array de skills (si es 1 o mas)


        if($arraySkills)
        {
            Colaborator::agregarSkills($arraySkills, $idColaborator);
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
