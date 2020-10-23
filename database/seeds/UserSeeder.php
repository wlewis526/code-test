<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    public function run()
    {
		User::create([
			'first_name' => 'Testy',
			'last_name' => 'McTesterson',
			'email' => 'wlewis.wlewis@gmail.com',
			'password' => Hash::make('password'),
		]);
		
		User::create([
			'first_name' => 'Jello',
			'last_name' => 'Biafra',
			'email' => 'jello@holiday.kh',
			'password' => Hash::make('SoIThrewTheRock'),
		]);
		
		User::create([
			'first_name' => 'Greg',
			'last_name' => 'Graffin',
			'email' => 'greg@epitaph.org',
			'password' => Hash::make('NoControl'),
		]);
		
		User::create([
			'first_name' => 'Dick',
			'last_name' => 'Lucas',
			'email' => 'dick_lucas@bath.co.uk',
			'password' => Hash::make('WhenTheBombDrops'),
		]);
		
        User::create([
			'first_name' => 'Scott',
			'last_name' => 'Sturgeon',
			'email' => 'stza@ninth_and_c.org',
			'password' => Hash::make('RockThe40oz'),
		]);
    }
}