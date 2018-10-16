<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colaborator extends Model
{
	use SoftDeletes;

    protected $table = 'colaborators';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    protected $softDelete = true;

    public function colabsSkills()
    {
        return $this->hasMany('App\ColabsSkills', 'colab_id');
    }

    public static function agregarUsuario($nombre, $apellido, $edad, $dni, $legajo, $puesto, $mail)
    {
    	$colaborator = new Colaborator();

        $colaborator->nombre = $nombre;
        $colaborator->apellido = $apellido;
        $colaborator->edad = $edad;
        $colaborator->dni = $dni;
        $colaborator->legajo = $legajo;
        $colaborator->puesto = $puesto;
        $colaborator->mail = $mail;

        $colaborator->save();

        return $colaborator->id;
    }

    public static function modificarUsuario($id, $nombre, $apellido, $edad, $puesto)
    {
    	$colaborator = Colaborator::find($id);

        $colaborator->nombre = $nombre;
        $colaborator->apellido = $apellido;
        $colaborator->edad = $edad;
        $colaborator->puesto = $puesto;

        $colaborator->save();
    }

    public static function agregarSkills($arraySkills, $idColaborator)
    {
    	foreach($arraySkills as $skill)
        {
            /*
             * Chequea si el combo colab_id y skill_id existen
             */
            $validador = ColabsSkills::where('colab_id','=',$idColaborator)
                            ->where('skill_id','=',$skill)
                            ->first();

            /*
             * Si el combo colab_id y skill_id NO existen, entonces los asigna
             *
             * Se crea una nueva instancia por cada iteracion porque sino, en vez de insertar, intenta hacer update y rompe
             */
            if(!($validador))
            {
                $colabSkill = new ColabsSkills();

                $colabSkill->skill_id = $skill;
                $colabSkill->colab_id = $idColaborator;

                $colabSkill->save();
            }       

        }
    }
}
