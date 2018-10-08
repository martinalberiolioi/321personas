<?php

use Illuminate\Database\Seeder;

class skillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$someSkills = ['debugging', 'testing', 'back-end', 'front-end', 'deploying', 'planning'];
    	//hace un array para ser recorrido con el FOR. Sino, solo pone el ultimo registro
    	for($i = 0; $i < 6; $i++){
    		\DB::table('skills')->insert(array(
		           'nombre' => $someSkills[$i],
		           'created_at' => date('Y-m-d H:m:s'),
		           'updated_at' => date('Y-m-d H:m:s')
			));
    	}
    }
}
