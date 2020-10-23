<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUser extends Model
{
	protected $table = "product_user";
	public $fillable = ["product_id", "user_id"];
	
    public function product()
	{
		return $this->belongsTo(Product::class);
	}
	
    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
