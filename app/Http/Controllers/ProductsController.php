<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index() 
	{
		$products = Product::with('creator')->get();
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
		//associate product with user
		$productUser = new ProductUser([
			'product_id' => $product->id,
			'user_id' => Auth::user()->id
		]);
		try {
			$productUser->save();
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
		$product->fill(Request::input());
		$product = $product->saveForUser(Auth::user()->id);
		return Response::json($product);
	}
	
	public function destroy($id)
	{
		$product = Product::findOrFail($id);
		if ($product->created_by != Auth::user()->id) {
			return Response::json("Deleting products created by other users is not allowed.", 403);
		}
		ProductUser::where('product_id', $id)->get()->each(function($productUser) {
			$productUser->delete();
		});
		$product->delete();
		return Response::json($product);
	}
	
	public function image($id)
	{
		Request::validate([
			'image' => 'required',
		]);
		
		$product = Product::findOrFail($id);
		$base64 = Request::input("image");
		
		preg_match("/data:image\/(.*?);/",$base64, $ext);
		$base64 = preg_replace('/data:image\/(.*?);base64,/','',$base64);
		$base64 = str_replace(' ', '+', $base64);
		$fileName = dechex(rand((1 << 15), (1 << 16))) 
			. '_' 
			. dechex(time()) 
			. '.' 
			. $ext[1];
		$decoded = base64_decode($base64);
		Storage::disk('public')->put($fileName, $decoded);
		$path = asset("storage/{$fileName}");
		
		$product->image = $path;
		$product = $product->saveForUser(Auth::user()->id);
		return Response::json($product);
	}
}
