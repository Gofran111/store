<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\quotations;
use App\Models\quotation_details;

use App\Models\Post;
use App\Models\User;
use Auth;
use TCPDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class QutationControllers extends Controller
{
 
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function show(){
        $products=Product::where('status', 'active')->get();
        return view('frontend.qutation.product-lists')->with('source',null)->with('products',$products);
    }
    public function pdf($id){
        $orders=quotations::where('id',$id)->first();
        $details = quotation_details::where('quot_id', $orders->id)->get();
        return view('backend.enventory.qutation.file')->with('orders', $orders)->with('details', $details);
    }

    
}
