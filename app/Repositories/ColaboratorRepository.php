<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class ColaboratorRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Colaborator";
    }

    function ExisteColabSkill($skills, $colaborator)
    {
    	foreach($skills as $skill)
    	{
    		$existeFila = $colaborator->skill()
                          ->where('skill_id','=',$skill->id)
                          ->where('colab_id','=',$colaborator->id) 
                          ->first();

	        if(!($existeFila))
	        {
	            $colaborator->skill()->attach($skill->id);
	        }

    	}
    	
    }
}