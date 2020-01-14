<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product_Image;
use App\Product_Price;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    public function add() {

        $unique = false;
        $code = "";

        $tested = [];
        do{
            $random = Str::random(6);
            if( in_array($random, $tested) ){
                continue;
            }
            $count = Product::where('code', $random)->count();
            $tested[] = $random;
            if( $count == 0){
                $unique = true;
                $code = $random;
            }
        }
        while(!$unique);

        return view('admin.products.add', [
            'code'=>$code,
            'categories' => Category::get()
        ]);
    }

    function isCurrency($number){
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }

    public function submitProduct(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'code' => 'required|max:6|min:6|unique:products',
            'name' => 'required|max:191',
            // 'cost' => 'required',
            // 'selling_cost' => 'required',
            // 'quantity' => 'required|integer',
            'category_id' => 'required',
        ]);

        if($validatedData->fails()) {
            return Redirect::action('ProductController@add')->withErrors($validatedData->messages());
        }

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        // $product->cost = $request->cost;
        // $product->selling_cost = $request->selling_cost;
        // $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->created_by = Auth::user()->id;
        $product->updated_by = Auth::user()->id;
        $product->is_ready_for_sale = '1';


        // $errors = [];
        //
        // if(!$this->isCurrency($request->cost)) {
        //     $errors[] = "The Product cost must be decimal!";
        // }
        //
        // if(!$this->isCurrency($request->selling_cost)) {
        //     $errors[] = "Product Selling Cost must be decimal!";
        // }
        //
        // if(count($errors)>0) {
        //     return Redirect::action('ProductController@add')->withErrors($errors);
        // }

        try{
            $product->save();
        }
        catch(\Exception $e) {
            return Redirect::action('ProductController@add')->withErrors("The data has been tempered in midway! try again");
        }
        return redirect(route('manage-products'));
    }

    public function manage_products() {
        return view('admin.products.manage-products', [
            'products' => Product::get()
        ]);
    }

    public function add_photos($id) {
        return view('admin.products.add-product-images', ['product'=> Product::find($id)]);
    }

    public function submitPhotos(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'product_id' => 'required',
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:500'

        ]);

        if($validatedData->fails()) {
            return Redirect::route('manage-products')->withErrors($validatedData->messages());
        }

        $product = Product::find($request->product_id);
        if($product == null) {
            return Redirect::route('manage-products')->withErrors("Data has been tempered in midway! try again!");
        }

        foreach($request->photos as $photo){
            $img = new Product_Image();

            $img->product_id = $product->id;

            $content = file_get_contents($photo);
            $type = pathinfo($photo, PATHINFO_EXTENSION);
            $base64 = base64_encode($content);
            $base64 = 'data:image/'.$type.';base64,'.$base64;

            $img->image = $base64;
            try{
                $img->save();
            }
            catch(\Exception $e) {
                return Redirect::route('manage-products')->withErrors("Data has been tempered in midway! try again!");
            }

        }
        return Redirect::route('manage-products')->withErrors("Successfully Uploaded Photos!");;
    }

    public function viewPhotos($id) {
        $images = Product_Image::get()->where('product_id', $id);
        $product = Product::find($id);
        return view('admin.products.view-photos', ['product'=> $product, 'images'=>$images ]);
    }

    public function deleteProductPhoto($id) {
        try {
            $image = Product_Image::find($id);
            $product = Product::find($image->product_id);
        }
        catch (\Exception $e) {
            return Redirect::route('manage-products')->withErrors("Data has been tempered in midway! try again!");
        }
        $res = Product_Image::destroy($id);
        if($res) {
            return Redirect::route('viewPhotos', ['id' => $product->id])->withErrors("Successfully Deleted Photo!");
        }
        return Redirect::route('viewPhotos', ['id' => $product->id])->withErrors("Failed to Delete Photo!");

    }

    public function deleteProduct($id) {
        try {
            $res = Product_Image::where('product_id', $id)->delete();
            $res = Product::destroy($id);
        } catch (\Exception $e) {
            return Redirect::route('manage-products')->withErrors("Data has been tempered in midway! try again!");
        }
        if($res) {
            return Redirect::route('manage-products')->withErrors("Successfully Deleted Product!");
        }
        return Redirect::route('manage-products')->withErrors("Failed to delete Product!");
    }

    public function changeProductPrice($id) {
        $product = Product::find($id);
        if($product == null) {
            return Redirect::route('manage-products')->withErrors("Data has been tempered in midway! try again!");
        }
        return view('admin.products.change-price', ['product' => $product]);
    }

    public function updateProductPrice(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'selling_cost' => 'required',
            'product_id' => 'required',
        ]);

        if($validatedData->fails()) {
            return Redirect::route('manage-products')->withErrors($validatedData->messages());
        }

        $errors = [];

        if(!$this->isCurrency($request->selling_cost)) {
            $errors[] = "Product Selling Cost must be decimal!";
        }
        if(count($errors)>0) {
            return Redirect::route('changeProductPrice', ['id'=>$request->product_id])->withErrors($errors);
        }

        $product = Product::find($request->product_id);

        $product_price = new Product_Price();

        $product_price->selling_cost = $request->selling_cost;
        $product_price->created_by = Auth::user()->id;
        $product_price->updated_by = Auth::user()->id;
        $product_price->Product()->associate($product);
        $product_price->save();

        //$product->save();
        return Redirect::route('manage-products')->withErrors("Successfully Updated Price!");
    }
}
