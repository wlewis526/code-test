<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;
use App\Subscription;

class UserSeeder extends Seeder
{
    public function run()
    {
		$wes = User::create([
			'first_name' => 'Testy',
			'last_name' => 'McTesterson',
			'email' => 'wlewis.wlewis@gmail.com',
			'password' => Hash::make('password'),
			'api_token' => Str::random(60),
		]);
		
		Subscription::create([
			'user_id' => $wes->id,
			'active' => 1
		]);
		
		$jello = User::create([
			'first_name' => 'Jello',
			'last_name' => 'Biafra',
			'email' => 'jello@holiday.kh',
			'password' => Hash::make('SoIThrewTheRock'),
			'api_token' => Str::random(60),
		]);
		
		Subscription::create([
			'user_id' => $jello->id,
			'active' => 1
		]);
		
		$greg = User::create([
			'first_name' => 'Greg',
			'last_name' => 'Graffin',
			'email' => 'greg@epitaph.org',
			'password' => Hash::make('NoControl'),
			'api_token' => Str::random(60),
		]);
		
		Subscription::create([
			'user_id' => $greg->id,
			'active' => 1
		]);
		
		$dick = User::create([
			'first_name' => 'Dick',
			'last_name' => 'Lucas',
			'email' => 'dick_lucas@bath.co.uk',
			'password' => Hash::make('WhenTheBombDrops'),
			'api_token' => Str::random(60),
		]);
		
		Subscription::create([
			'user_id' => $dick->id,
			'active' => 0
		]);
		
        User::create([
			'first_name' => 'Scott',
			'last_name' => 'Sturgeon',
			'email' => 'stza@ninth_and_c.org',
			'password' => Hash::make('RockThe40oz'),
			'api_token' => Str::random(60),
		]);
		
		//no subscription
    }
}
