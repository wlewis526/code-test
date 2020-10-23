<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $fillable = [ 'name', 'description', 'price', 'image' ];
	
    public function users() 
	{
		return $this->hasAndBelongsToMany(User::class);
	}
	
	public function creator()
	{
		return $this->belongsTo(User::class, "created_by");
	}
}
