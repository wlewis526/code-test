<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductUser;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductUsersController extends Controller
{
    public function index()
	{
		$products = Auth::user()->products;
		return Response::json($products);
	}
	
	public function update($product_id)
	{
		$user_id = Auth::user()->id;
		$product = Product::findOrFail($product_id);
		$existing = ProductUser::where('product_id', $product_id)->where('user_id', $user_id)->first();
		if ($existing != null) {
			return Response::json('User is already associated with this product.', 422);
		}
		$productUser = new ProductUser(['user_id' => $user_id, 'product_id' => $product_id]);
		$productUser->save();
		return Response::json($product);
	}
	
	public function destroy($product_id)
	{
		$productUser = ProductUser::where('product_id', $product_id)->where('user_id', Auth::user()->id)->firstOrFail();
		$product = $productUser->product;
		
		$productUser->delete();
		return Response::json($product);
	}
}
