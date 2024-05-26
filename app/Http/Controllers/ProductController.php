<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\Category;

use Illuminate\Support\Str;


class ProductController extends Controller
{

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {   $products = product::where('status', 'active')->paginate(15);
        // $products=Product::orderBy('id','ASC')->paginate(15);
        // return $products;
        return view('backend.product.index')->with('products',$products)->with('store',$store);
    }
    public function indeedit()
    {
        $products=Product::orderBy('id','ASC')->paginate(100);
        // return $products;
        return view('backend.product.indeedit')->with('products',$products);
    }

    public function allprodct()
    {
        $products=Product::orderBy('id','ASC')->paginate(100);
        // return $products;
        return view('backend.product.allproduct')->with('products',$products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        
        $category=Category::all();
        return view('backend.product.create')->with('categories',$category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'title'=>'string|required', 
            'photo'=>'required',
            'barcode'=>'required',
            'description'=>"nullable",
            'price'=>"numeric",
            'minprice'=>"numeric",
            'maxprice'=>"numeric",
            'cat_id'=>'required|exists:categories,id', 
            'status'=>'required|in:active,inactive',
        ]);
        $product=Product::where('barcode', $request->barcode)->first();
    if($product){
        request()->session()->flash('error',' لم تتم الاضافة رقم الباركود موجود');
    }else{

        $data= new Product();
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        $data['slug']=$slug;
        $image = $request->photo;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $data->photo= $request->photo->move('image',$imagename);
        $data->title= $request->title;
        $data->price= $request->price;
        $data->minprice= $request->minprice;
        $data->maxprice= $request->maxprice;
        $data->description= $request->description;
        $data->cat_id= $request->cat_id;
        $data->status = $request->status;
        $data->barcode= $request->barcode;
        $status=$data->save();
       
      

        if($status){
            request()->session()->flash('success','تمت اضافة بطاقة جديدة');
        }
        else{
            request()->session()->flash('error','خطأ حاول مجددا  ! !');
        } 
    }
        return redirect()->route('indeedit');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

      /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $product=Product::findOrFail($id);
        $category=Category::all();
        $items=Product::where('id',$id)->get();
        // // return $items;
        return view('backend.product.edit')->with('product',$product)
                
                    ->with('categories',$category)->with('items',$items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $data =Product::findOrFail($id);
        $request->validate([
            'title'=>'string|required', 
            'photo'=>'nullable',
            'barcode'=>'required',
            'description'=>"nullable",
            'price'=>"numeric",
            'minprice'=>"numeric",
            'maxprice'=>"numeric",
            'cat_id'=>'required|exists:categories,id', 
            'status'=>'required|in:active,inactive',
        ]);
        $product=Product::where('barcode', $data->barcode)->first();
        if($product->barcode == $request->barcode && $data->id != $product->id){
            request()->session()->flash('error',' لم يتم التعديل رقم الباركود موجود');
        }else{
        if($request->photo){ 
            $image = $request->photo;
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $data->photo = $request->photo->move('image',$imagename);
            }
        
            $data->title= $request->title;
            $data->price= $request->price;
            $data->minprice= $request->minprice;
            $data->maxprice= $request->maxprice;
            $data->description= $request->description;
            $data->cat_id= $request->cat_id;
            $data->status = $request->status;
            $data->barcode= $request->barcode;
            $status=$data->save();
    
            if($status){
                request()->session()->flash('success','تم تعديل بطاقة المادة بنجاح');
            }
            else{
                request()->session()->flash('error',' حدث خطأ أعد المحاولة !!');
            }
        }
            return redirect()->route('indeedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $product=Product::findOrFail($id);
    //     $status=$product->delete();
        
    //     if($status){
    //         request()->session()->flash('success','Product successfully deleted');
    //     }
    //     else{
    //         request()->session()->flash('error','Error while deleting product');
    //     }
    //     return redirect()->route('product.index');
    // }

    }
