<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class colaboratorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

		for ($i=0; $i < 50; $i++) {
		    \DB::table('colaborators')->insert(array(
		           'nombre' => $faker->firstNameFemale,
		           'apellido' => $faker->lastName,
		           'edad' => $faker->numberBetween($min = 18, $max = 55),
		           'dni' => $faker->numberBetween($min = 12000000, $max = 45000000),
		           'legajo' => $faker->randomDigitNotNull,
		           'puesto' => $faker->randomElement(['back end developer','full stack developer','front end developer']),
		           'mail' => $faker->email,
		           'created_at' => date('Y-m-d H:m:s'),
		           'updated_at' => date('Y-m-d H:m:s')
		    ));
		}
    }
}
