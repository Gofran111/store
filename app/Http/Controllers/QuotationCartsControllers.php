<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\quotation_carts;
use Illuminate\Support\Str;
use Helper;
use Auth;
use Notification;

class QuotationCartsControllers extends Controller
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
            'price'  =>  'required',
        ]);

         $product = Product::where('slug', $request->slug)->first();
        if(  $product->minprice <  $request->price && $request->price < $product->maxprice){
            $already_cart = quotation_carts::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
            // return $already_cart;
            if($already_cart) {
                return back()->with('error',' قد اضفت هذه المادة بالفعل يمكنك المتابعة لاظهارها');            
            }else{
                $cart = new quotation_carts;
                $cart->user_id = auth()->user()->id;
                $cart->product_id = $product->id;
                $cart->price = $request->price;
                $cart->vate = $request->vate;
                $cart->pro_dscont = $request->pro_dscont;
                $cart->prod_notes = $request->prod_notes;
                $cart->quantity = $request->quant[1];
                $cart->save();
            }
        }else{
            return back()->with('error','ادخل سعر ضمن المجال المحدد');
       }
       
        request()->session()->flash('success','تمت الاضافة بنجاح.');
        return back();       
    } 
    

    public function cartDelete(Request $request){
        $cart = quotation_carts::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','تم الحذف بنجاح');
            return back();  
        }
        request()->session()->flash('error','حدث خطأ حاول مجددا');
        return back();       
    }     


    public function cartUpdate(Request $request) {
        $success = '';
    // dd($request);
        foreach ($request->quant as $key => $quantity) {
            $cartId = $request->qty_id[$key];
            $cart = quotation_carts::find($cartId);
    
            if ($cart) { 
                 $product = Product::find($cart->product_id);
                //  return   $request->price[$key];
                if(  $product->minprice <  $request->price[$key] && $request->price[$key] < $product->maxprice){
                    $cart->price = $request->price[$key];
                    $cart->pro_dscont = $request->pro_dscont[$key];
                    $cart->prod_notes = $request->prod_notes[$key];
                    $cart->vate = $request->vate[$key];
                    $cart->quantity = $quantity;
                    $cart->save();
                    $success = 'تم تحديث المنتجات بنجاح! ';
                }else{
                    return back()->with('error','ادخل سعر ضمن المجال المحدد');
                }
            } else {
                return back()->with('errors', 'هناك خطا ما!');
        }
        }
        return back()->with('success', $success);

    }

}