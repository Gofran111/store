<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store_movemnts_orders extends Model
{
    use HasFactory;
    
    // protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return store_movemnts_orders::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=store_movemnts_orders::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(movements_carts::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function store_orders(){
        return store_movemnts_orders::all();
    }
    
      //strore movment show
      public function one_store_orders($id){
        return store_movemnts_orders::where('id', $id)->first();
    }
}