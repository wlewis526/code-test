<?php

namespace App;

use App\ProductUser;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $fillable = [ 'name', 'description', 'price', 'image' ];
	
    public function users() 
	{
		return $this->belongsToMany(User::class);
	}
	
	public function creator()
	{
		return $this->belongsTo(User::class, "created_by");
	}
	
	public function saveForUser($user_id)
	{
		if ($this->created_by == $user_id) {
			$this->save();
			return $this;
		}
		
		$newProduct = new Product([
			'name' => $this->name,
			'description' => $this->description,
			'price' => $this->price,
			'image' => $this->image,
		]);
		$newProduct->created_by = $user_id;	//created_by is not fillable so this has to be done here
		$newProduct->save();
		//check if user was attached to the old product and move the association to the new product
		$productUser = ProductUser::where('product_id', $this->id)->where('user_id', $user_id)->first();
		if ($productUser) {
			$productUser->product_id = $newProduct->id;
			$productUser->save();
		}
		return $newProduct;
	}
}
