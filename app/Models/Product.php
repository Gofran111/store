<?php

namespace App\Models;
use App\Models\Aproduct;use App\Models\Sproduct;use App\Models\Mproduct;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
   
    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    public static function getAllProduct(){
        return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }

    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    // my export excel data
    public function product_list(){
        // $this->db->select('*');
        // $this->db->from('product');
        // $query = $this->db->get();
        // return $query->result();
        return Product::where('status','active')->get();
    }

}
