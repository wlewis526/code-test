<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function users() 
	{
		return $this->hasAndBelongsToMany(User::class);
	}
	
	public function createdBy()
	{
		return $this->belongsTo(User::class, "created_by");
	}
}
