<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use App\Models\Post;
use App\Models\movements_carts;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class MovmentsControllers extends Controller
{
 
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    public function show($order_type){
        // dd($order_type);
            $products = Product::where('status', 'active')->get();
        return view('frontend.orders.product-lists')->with('order_type', $order_type)->with('products', $products);
    }
    public function cart($order_type){
        // dd($order_type);
        $user_id = Auth()->user()->id;
        $carts = movements_carts::with('product')->where('user_id',$user_id)->where('order_type',$order_type)->get();
        // dd($carts);
        return view('frontend.orders.cart')->with('carts', $carts)->with('order_type', $order_type);
    }
    
}
