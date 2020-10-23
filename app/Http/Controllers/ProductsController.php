<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{
    public function index() 
	{
		$products = Product::get();
		return Response::json($products);
	}
	
	public function get($id)
	{
		$product = Product::findOrFail($id);
		return Response::json($product);
	}
	
	public function store()
	{
		Request::validate([
			'name' => 'required',
			'description' => 'required',
			'price' => 'required|numeric',
		]);
		
		$product = new Product(Request::input());
		$product->created_by = Auth::user()->id;
		try {
			$product->save();
		} catch (\Exception $e) {
			return Response::json($e->getMessage(), 403);
		}
		return Response::json($product);
	}
	
	public function update($id)
	{
		Request::validate([
			'name' => 'required',
			'description' => 'required',
			'price' => 'required|numeric',
		]);
		
		$product = Product::findOrFail($id);
		if ($product->created_by == Auth::user()->id) {
			$product->fill(Request::input());
		} else {
			$product = new Product(Request::input());
			$product->created_by = Auth::user()->id;
		}
		try {
			$product->save();
		} catch (\Exception $e) {
			return Response::json($e->getMessage(), 400);
		}
		return Response::json($product);
	}
	
	public function destroy($id)
	{
		$product = Product::findOrFail($id);
		if ($product->created_by != Auth::user()->id) {
			return Response::json("Deleting products created by other users is not allowed.", 403);
		}
		$product->delete();
		return Response::json($product);
	}
}
