<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $hidden = [
        'password'
    ];
	
	public function products() 
	{
		return $this->hasAndBelongsToMany(Product::class);
	}
	
	public function createdProducts() 
	{
		return $this->hasMany(Product::class, "created_by");
	}
	
	public function subscription()
	{
		return $this->hasOne(Subscription::class);
	}
}
