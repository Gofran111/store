<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\quotation_carts;
use App\Models\quotations;
use App\Models\quotation_details;
use App\Models\Shipping;
use App\Models\Product;

use App\Models\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;


class QutationOrdersControllers extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $orders=quotations::orderBy('id','DESC')->paginate(10);
          
            return view('backend.enventory.qutation.index')->with('orders',$orders);
        }
  
        public function envoy_index()
        {
            $orders=quotations::where('status','active')->orderBy('id','DESC')->paginate(10);
          
            return view('backend.enventory.envoy.qutation')->with('orders',$orders);
        }
    
        public function store(Request $request)
    {
        // dd( $request); 
        if(empty(quotation_carts::where('user_id',auth()->user()->id)->first())){
            request()->session()->flash('error','لا يوجد مواد !');
            return back();
        }
            $order=new quotations();
            $order->user_id=$request->user_id;
            $order->delevery_date =$request->delevery_date;
            $order->customer =$request->customer;
            $order->time_valided =$request->time_valided;
            $order->payments_terms=$request->payments_terms;
            $order->qout_type =$request->qout_type;
            $order->guarantee=$request->guarantee;
            $order->discount = $request->discount;
            $order->title = $request->title;
            $order->qut_num = 1;
            $status=$order->save();
            foreach($request->pro_id as $key =>$pro){
                $details = new quotation_details();
                $details->quantity=$request->quantity[$key];
                $details->pro_id = $request->pro_id[$key];
                $details->price = $request->price[$key];
                $details->vate = $request->vate[$key];
                $details->pro_dscont = $request->pro_dscont[$key];
                $details->notes = $request->prod_notes[$key];
                $details->quot_id = $order->id;
                $details->save();
             } 
   
        if($status){ 
                foreach($request->cart_id as $key =>$cart_id){
                   $cart = quotation_carts::find($cart_id);
                        if ($cart) {
                            $cart->delete();}
                }
                session()->forget('quotation_carts');
                request()->session()->flash('success','تم الاضافة بنجاح');
                return redirect()->route('envoy.qutation.index');
            
        }else{
            request()->session()->flash('error','حدث خطا ما ');
            return redirect()->back();
        }
      
    } 

     public function create(){}
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $orders = quotations::where('id', $id)->first();
            // return $orders;
            $details = quotation_details::where('quot_id', $orders->id)->get();
            // return $details;
            return view('backend.enventory.qutation.show')->with('orders', $orders)->with('details', $details);
        }
        
        public function edit($id)
        {
            $order = quotations::where('id', $id)->first();
            $details = quotation_details::where('quot_id', $order->id)->get();
            // return $details;
            return view('backend.enventory.qutation.edit')->with('order', $order)->with('details', $details);
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
            $order = quotations::where('id', $id)->first();
            // return $order->id;  
            $order->delevery_date =$request->delevery_date;
            $order->customer =$request->customer;
            $order->time_valided =$request->time_valided;
            $order->payments_terms=$request->payments_terms;
            $order->qout_type =$request->qout_type;
            $order->guarantee=$request->guarantee;
            $order->discount = $request->discount;
            $order->title = $request->title;
            $details = quotation_details::where('quot_id', $order->id)->get();
            foreach ($details as $key => $detail) {
                $detail->quantity=$request->quantity[$key];
                $detail->pro_id = $request->pro_id[$key];
                $detail->price = $request->price[$key];
                $detail->pro_dscont = $request->pro_dscont[$key];
                $details->vate = $request->vate[$key];
                $detail->notes = $request->prod_notes[$key];
                $status2 = $detail->save();
            }
            $status= $order->save();
            if($status && $status2){
                request()->session()->flash('success','تم اضافة مادة ');
            }else{
                request()->session()->flash('error','حدث خطا ');
            }
            return redirect()->route('qutation.index');
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id) {
            $order = quotations::where('id', $id)->first();
            $order->status = 'inactive';
            $status = $order->save();
            if ($status) {
                request()->session()->flash('success','لقد تم الحذف');
            }else{
                request()->session()->flash('error','جدث خطا ');
            }
            return redirect()->back();
        }
    
        // // PDF generate
        // public function pdf(Request $request){
        //     $order=quotation::getAllOrder($request->id);
        //     // return $order;
        //     $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        //     // return $file_name;
        //     $pdf=PDF::loadview('backend.enventory.inbound.pdf',compact('order'));
        //     return $pdf->download($file_name);
        // }


    }