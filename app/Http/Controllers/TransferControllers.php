<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use App\Models\transfer_carts;

use App\Models\User;

use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class TransferControllers extends Controller
{
 
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function show(){
        $products=Product::where('status', 'active')->get();
        return view('frontend.inbound.product-lists')->with('source',null)->with('products',$products);
    }

    public function source(Request $request){
     $source = $request->source;
        $products=Product::where('status', 'active')->get();
        return view('frontend.inbound.product-lists')->with('source',$source)->with('products',$products);
    }
    public function cart($source){
        // dd($order_type);
        $user_id = Auth()->user()->id;
        $carts = transfer_carts::with('product')->where('user_id',$user_id)->where('store',$source)->get();
        // dd($carts);
        return view('frontend.inbound.cart')->with('carts', $carts)->with('source', $source);
    }
   


}
