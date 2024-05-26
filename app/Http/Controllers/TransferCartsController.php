<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\transfer_carts;
use App\Models\store1s;
use App\Models\store2s;
use App\Models\store3s;
use App\Models\store4s;
use Notification;
use Illuminate\Support\Str;
use Helper;
use Auth;

class TransferCartsController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function singleAddToCart(Request $request){
        // dd($request);
          $request->validate([
            'slug'   =>  'required',
            'quant'  =>  'required',
            'source' =>  'required',
        ]);
       
         $source = $request->source;
        //  return  $source;
        if ($source == null) {
            return back()->with('error',' لم تحدد المصدر');
        }
         $product = Product::where('slug', $request->slug)->first();
         if ( $source != 'out') {
            if($request->stock < $request->quant[1]){
                    return back()->with('error',' خالي المستودع .');
                    }
             if ( $request->quant[1] < 1 ) {
            request()->session()->flash('error','ادخال خاطئ');
            return back();
        } 
     }   
        $already_cart = transfer_carts::where('user_id', auth()->user()->id)->where('store', $source)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            $already_cart->store = $source;
            if (($request->stock < $already_cart->quantity || $request->stock <= 0) && $source != 'out') return back()->with('error','الستودع خالي!.');
            $already_cart->save();
        }else{
            $cart = new transfer_carts;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->store = $source;
            $cart->quantity = $request->quant[1];
            $cart->save();
        }
        request()->session()->flash('success','تمت الاضافة الطلبية بنجاح.');
        return back();    
    } 
    

    public function cartDelete(Request $request){
        $cart = transfer_carts::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','تم الحذف بنجاح');
            return back();  
        }
        request()->session()->flash('error','حدث خطأ حاول مجددا');
        return back();       
    } 
    
    
    public function cartUpdate(Request $request) {
        $errors = '';
        $success = '';
   
        foreach ($request->quant as $key => $quantity) {
            $cartId = $request->qty_id[$key];
            $cart = transfer_carts::find($cartId);
            // return $request->store ;
            if ($request->store == 'store1s') {
                $store = store1s::where('pro_id',$cart->product_id)->first();
            } else if ($request->store == 'store2s'){
                $store = store2s::where('pro_id',$cart->product_id)->first();
            } else if ($request->store == 'store3s'){
                $store = store3s::where('pro_id',$cart->product_id)->first();
            } else if ($request->store == 'store4s'){
                $store = store4s::where('pro_id',$cart->product_id)->first();
            }else{
                $store =0;
            }
         
            if ($store->stock < $quantity) {
                $errors = 'الكمية المطلوبة أكبر من المخزون للمنتج: ' . $cart->product_id;
                 request()->session()->flash('error', $errors);
                return redirect()->route('in_cart',$request->store);
          }
                // return 1;
                $cart->quantity = $quantity;
                $cart->save();
                $success = 'تم تحديث الكميات للمنتجات بنجاح! ';
                    
           
            }
            request()->session()->flash('success', $success);
            return redirect()->route('in_cart',$request->store);
    }

}