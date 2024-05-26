<?php
use App\Models\Message;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

use App\Models\Shipping;
use App\Models\movements_carts;
use App\Models\quotation_carts;
use App\Models\transfer_carts;
use App\Models\store_movemnts_details;
use App\Models\store_movemnts_orders;
use App\Models\quotations;


// use App\Models\inbound_orders;
// use Auth;
class Helper{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllCategory(){
        $category = Category::orderBy('id','DESC')->get();
        return $category;
    } 
    public static function getAllProducty(){
        return Product::orderBy('id','DESC')->get();
    } 

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    // // Cart Count
    // public static function cartCount($user_id=''){
       
    //     if(Auth::check()){
    //         if($user_id=="") $user_id=auth()->user()->id;
    //         return quotation_carts::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
    //     }
    //     else{
    //         return 0;
    //     }
    // }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return quotation_carts::with('product')->where('user_id',$user_id)->get();
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return quotation_carts::where('user_id',$user_id)->sum('price');
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    public static function totalCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return quotation_carts::where('user_id',$user_id)->sum('quantity');
        }
        else{
            return 0;
        }
    }
///////////////////////////////////////////////////
  // outbound Cart Count
  public static function outcartCount($user_id=''){
       
    if(Auth::check()){
        if($user_id=="") $user_id=auth()->user()->id;
        return movements_carts::where('user_id',$user_id)->sum('quantity');
    }
    else{
        return 0;
    }
}

    // Total amount cart
    public static function totaloutCart($user_id='', $order_type){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return movements_carts::where('user_id',$user_id)->where('order_type',$order_type)->sum('quantity');
        }
        else{
            return 0;
        }
    }

//////////////////////////////////////////////////////


public static function totalinCart($user_id=''){
    if(Auth::check()){
        if($user_id=="") $user_id=auth()->user()->id;
        return transfer_carts::where('user_id',$user_id)->sum('quantity');
    }
    else{
        return 0;
    }
}


////////////////////////////////////////////////////////


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }
    public static function cartorders($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return store_movemnts_orders::where('user_id', $user_id)
                                   ->whereNotNull('created_at') // Add this condition to filter orders with a non-null created_at value
                                   ->distinct('created_at') // Use distinct instead of unique to get unique values of created_at
                                   ->count();
        }
        else{
            return 0;
        }
    }
    public static function qut($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return quotations::where('user_id', $user_id)
                                   ->whereNotNull('created_at') // Add this condition to filter orders with a non-null created_at value
                                   ->distinct('created_at') // Use distinct instead of unique to get unique values of created_at
                                   ->count();
        }
        else{
            return 0;
        }
    }


    public static function getTotalQuantityAndOrder( $id)
    {
        $totalQuantity =  store_movemnts_details::where('ord_id', $id)
                                ->sum('quantity');
        return $totalQuantity;
    }    
}

