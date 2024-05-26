<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title','slug','photo'];

 
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->paginate(10);
    }

 
    public function products(){
        return $this->hasMany('App\Models\Product','cat_id','id');
    }

    public static function getProductByCat($slug){
        // dd($slug);
        return Category::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug){
        // return $slug;
        return Category::with('sub_products')->where('slug',$slug)->first();
    }

}
