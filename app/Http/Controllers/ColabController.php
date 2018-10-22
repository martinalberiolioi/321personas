<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColaboratorFormRequest;
use App\Http\Requests\ModificarColaboratorFormRequest;
use Illuminate\Support\Facades\Input;
use App\Repositories\ColaboratorRepository;
use App\Repositories\SkillRepository;
use App\Skill;
use App\Colaborator;

class colabController extends Controller
{

    protected $colabRepository;
    protected $skillRepository;

    public function __construct(ColaboratorRepository $colabRepository, skillRepository $skillRepository)
    {
        $this->colabRepository = $colabRepository;
        $this->skillRepository = $skillRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('personas/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {                       
        return view('personas/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColaboratorFormRequest $request)
    {        
        $skills = $this->skillRepository->find(Input::get('idSkill'));
        $colaborator = $this->colabRepository->create(Input::all());

        foreach($skills as $skill)
        {
            $colaborator->skill()->attach($skill->id);
        }       

        return view('welcome')->with('mensaje','Se agrego a la persona con exito!!'); 
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
        $skills = $this->skillRepository->scopeQuery(function($query){
            return $query->orderBy('nombre','asc');
        })->get();

        $persona = $this->colabRepository->find($id);

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
        $colaborator = $this->colabRepository->update(Input::all(), $id);
        $skills = $this->skillRepository->find(Input::get('idSkill'));     

        if($skills !== null)
        {
            $this->colabRepository->ExisteColabSkill($skills, $colaborator); 
        }

        return view('welcome')->with('mensaje', 'Se modifico a la persona con exito!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->colabRepository->delete($id);

        return view('welcome')->with('mensaje', 'Se elimino a la persona con exito!!');
    }

}
