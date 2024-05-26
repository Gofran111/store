<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\movements_carts;
use Illuminate\Support\Str;
use Helper;
use Notification;

class MovementsCartsController extends Controller
{
    protected $product=null;
    
    public function __construct(Product $product){
        $this->product=$product;

    }

    public function singleAddToCart(Request $request){
        // dd($request);

        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        $product = Product::where('slug', $request->slug)->first();
        if ($request->order_type == 'out') {
            if($request->stock < $request->quant[1]){
                return back()->with('error',' خالي المستودع .');
            }
            if ( $request->quant[1] < 0 ) {
                request()->session()->flash('error','ادخال خاطئ');
                return back();
            }    
        }
        $already_cart = movements_carts::where('user_id', auth()->user()->id)->where('order_type', $request->order_type )->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            $already_cart->order_type = $request->order_type ;
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            if (($request->stock < $already_cart->quantity || $request->stock <= 0 ) && $request->order_type == 'out') return back()->with('error','الستودع خالي!.');
            $already_cart->save();
        }else{
            $cart = new movements_carts;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->quantity = $request->quant[1];
            $cart->order_type = $request->order_type;
            $cart->save();
        }
        request()->session()->flash('success','تمت الاضافة بنجاح.');
        return back();       
    } 
    

    public function cartDelete(Request $request){
        $cart = movements_carts::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','تم الحذف بنجاح');
            return back();  
        }
        request()->session()->flash('error','حدث خطأ حاول مجددا');
        return back();       
    }     


    public function cartUpdate(Request $request) {
        $errors = [];
        $success = '';
    // dd($request);
        foreach ($request->quant as $key => $quantity) {
            $cartId = $request->qty_id[$key];
            $cart = movements_carts::find($cartId);
    
            if ($cart && $quantity > 0) {
                if ($request->stock < $quantity && $request->order_type == 'out') {
                    $errors[] = 'الكمية المطلوبة أكبر من المخزون للمنتج: ' . $cart->product->name;
                } else {
                    $cart->quantity = $request->quant[$key];
                    // return $cart->quantity;
                    $cart->save();
                    $success = 'تم تحديث الكميات للمنتجات بنجاح! ';
                }
            } else {
                return back()->with('errors','Invalid Cart!');
            }
        }
            return back()->with('success', $success);
    }

}
