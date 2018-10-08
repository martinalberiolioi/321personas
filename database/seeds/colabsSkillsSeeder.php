<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class colabsSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

		for ($i=0; $i < 10; $i++) {

		    \DB::table('colabs_skills')->insert(array(
	           'colab_id' => $faker->numberBetween($min = 1, $max = 50), //son 50 colaboradores
	           'skill_id' => $faker->numberBetween($min = 1, $max = 7), //son 7 skills
	           'created_at' => date('Y-m-d H:m:s'),
	           'updated_at' => date('Y-m-d H:m:s')
		    ));
		}
    }
}
