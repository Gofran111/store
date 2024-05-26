<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transfer_carts;
use App\Models\transfer_orders;
use App\Models\transfer_details;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\store1s;
use App\Models\store2s;
use App\Models\store3s;
use App\Models\store4s;

use App\Models\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App\Exports\InboundExport;
use App\Exports\ShowInExport;
use Maatwebsite\Excel\Facades\Excel;

class TransferOrders extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $orders=transfer_orders::orderBy('id','DESC')->paginate(10);
            
            return view('backend.enventory.inbound.index')->with('orders',$orders);
        }

        

        public function store(Request $request)
    {
        // dd( $request);
        if(empty(transfer_carts::where('user_id',auth()->user()->id)->first())){
            request()->session()->flash('error','لا يوجد مواد !');
            return back();
        }
        $ord=transfer_orders::find($request->rec_num);
        if($ord==null){
            $order=new transfer_orders();
            $order->user_id=$request->user_id;
            $order->rece_date=$request->rece_date;
            $order->rec_num=$request->rec_num;
            $order->recipient=$request->recipient;
            $order->deliverer=$request->deliverer;
            $order->store=$request->store;
            $status=$order->save();
            
            foreach($request->pro_id as $key =>$pro){
                $details = new transfer_details();
                $details->quantity=$request->quantity[$key];
                $details->pro_id = $request->pro_id[$key];
                $details->tran_id =  $order->id;
                $status2= $details->save();
                // dd ($details->pro_id );
                $num = 1;
                if ($order->store == 'store1s') {
                    $store = store1s::where('pro_id',$details->pro_id)->first();
                } else if ($order->store == 'store2s'){
                    $store = store2s::where('pro_id',$details->pro_id)->first();
                } else if ($order->store == 'store3s'){
                    $store = store3s::where('pro_id',$details->pro_id)->first();
                } else if ($order->store == 'store4s'){
                    $store = store4s::where('pro_id',$details->pro_id)->first();
                }else{
                    $num = 0;
                }
                if ($order->deliverer == 'store1s') {
                    $store2 = store1s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store1s();
                        $store2-> pro_id = $details->pro_id;
                    }
                } else if ($order->deliverer == 'store2s'){
                    $store2 = store2s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store2s();
                        $store2-> pro_id = $details->pro_id;
                    }
                } else if ($order->deliverer == 'store3s'){
                    $store2 = store3s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store3s();
                        $store2-> pro_id = $details->pro_id;
                    }
                } else if ($order->deliverer == 'store4s'){
                    $store2 = store4s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store4s();
                        $store2-> pro_id = $details->pro_id;
                    }
                }
                // dd($store2);
                if ($num == 1) {
                    $store->stock -=$details->quantity;
                    $store->save();
                }
                $store2->stock +=$details->quantity;
                $store2->save();
               } 
        }else{
            request()->session()->flash('success','رقم الايصال موجود من قبل');
            return redirect()->back();
        }
        if($status && $status2){ 
                foreach($request->cart_id as $key =>$cart_id){
                //    dd(transfer_carts::find($cart_id)); 
                    $cart = transfer_carts::find($cart_id);
                        if ($cart) {
                            $cart->delete();}
                }
                            
                session()->forget('transfer_carts');

                // dd($users);        
                request()->session()->flash('success','تم اضافة المادة بنجاح');
                return redirect()->route('in.order.index');
            
        }else{
            request()->session()->flash('success','فشل !');
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
            $orders = transfer_orders::where('id', $id)->first();
            $details = transfer_details::where('tran_id', $orders->id)->get();
            // return $details;
            return view('backend.enventory.inbound.show')->with('orders', $orders)->with('details', $details);
        }
        
        public function edit($id)
        {
            $orders = transfer_orders::where('id', $id)->first();
            $details = transfer_details::where('tran_id', $orders->id)->get();
            // return $details;
            return view('backend.enventory.inbound.edit')->with('orders', $orders)->with('details', $details);
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
            $orders = transfer_orders::where('id', $id)->first();
                $orders->rece_date = $request->rece_date;
                $orders->rec_num = $request->rec_num;
                $orders->recipient = $request->recipient;
                $status=$orders->save();
                $details = transfer_details::where('tran_id', $id)->get();
                foreach ($details as $key => $order) {
                    $old_qu = $order->quantity;
                    $order->quantity = $request->quantity[$key];
                    $status2 = $order->save();
                    
                    $num = 1;
                    
                    if ($order->store == 'store1s') {
                        $store = store1s::where('pro_id', $order->pro_id)->first();
                    } else if ($order->store == 'store2s') {
                        $store = store2s::where('pro_id', $order->pro_id)->first();
                    } else if ($order->store == 'store3s') {
                        $store = store3s::where('pro_id', $order->pro_id)->first();
                    } else if ($order->store == 'store4s') {
                        $store = store4s::where('pro_id', $order->pro_id)->first();
                    } else {
                        $num = 0;
                    }
                    
                    if ($num == 1) {
                        $store->stock += $old_qu;
                        $store->stock -= $order->quantity;
                        $store->save();
                    }
                    
                    if ($orders->deliverer == 'store1s') {
                        $store2 = store1s::where('pro_id', $order->pro_id)->first();
                    } else if ($orders->deliverer == 'store2s') {
                        $store2 = store2s::where('pro_id', $order->pro_id)->first();
                    } else if ($orders->deliverer == 'store3s') {
                        $store2 = store3s::where('pro_id', $order->pro_id)->first();
                    } else if ($orders->deliverer == 'store4s') {
                        $store2 = store4s::where('pro_id', $order->pro_id)->first();
                    }
                    // dd($store2);
                    if ($store2) {
                        $store2->stock -= $old_qu;
                        $store2->stock += $order->quantity;
                        $store2->save();
                    }
                }
                
            if( $status){
                request()->session()->flash('success','تم اضافة المادة بننجاح');
            }else{
                request()->session()->flash('success','Fail order');
            }
            return redirect()->route('in.order.index');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $orders = transfer_orders::where('id', $id)->first();
            $details = transfer_details::where('tran_id', $id)->get();
            $status = $orders->delete();
            // dd( $details);
            if(true){
                foreach($details as $order){
                    $old_qu = $order->quantity;
                    // return 1;
                        $num = 1;
                        if ($order->store == 'store1s') {
                            $store = store1s::where('pro_id',$order->pro_id)->first();
                        } else if ($order->store == 'store2s'){
                            $store = store2s::where('pro_id',$order->pro_id)->first();
                        } else if ($order->store == 'store3s'){
                            $store = store3s::where('pro_id',$order->pro_id)->first();
                        } else if ($order->store == 'store4s'){
                            $store = store4s::where('pro_id',$order->pro_id)->first();
                        }else{
                            $num = 0;
                        }
                        // return $num;
                        if ($orders->deliverer == 'store1s') {
                            $store2 = store1s::where('pro_id',$order->pro_id)->first();
                        } else if ($orders->deliverer == 'store2s'){
                            $store2 = store2s::where('pro_id',$order->pro_id)->first();
                        } else if ($orders->deliverer == 'store3s'){
                            $store2 = store3s::where('pro_id',$order->pro_id)->first();
                        } else if ($orders->deliverer == 'store4s'){
                            $store2 = store4s::where('pro_id',$order->pro_id)->first();
                        }
                        // dd($store2);
                        if ($num == 1) {
                            $store->stock +=$old_qu;
                            // return $store->stock;
                            $store->save();
                        }
                        $store2->stock -=$old_qu;
                        $store2->save();
                        $status = $order->delete();
                        // $status = true;
                           } 
                
                if($status){
                    request()->session()->flash('success','تم حذف المادة');
                }
                else{
                    request()->session()->flash('error','لم يتم حذف الداتا ');
                }
                return redirect()->back();
            }
            else{
                request()->session()->flash('error','لم يتم ايجاد الداتا');
                return redirect()->back();
            }
        }

        // // PDF generate
        // public function pdf(Request $request){
        //     $order=transfer_orders::getAllOrder($request->id);
        //     // return $order;
        //     $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        //     // return $file_name;
        //     $pdf=PDF::loadview('backend.enventory.inbound.pdf',compact('order'));
        //     return $pdf->download($file_name);
        // }

        public function export() 
    {
        return Excel::download(new InboundExport, 'orders_inbound.xlsx');
    }

    public function exportShow($rec_num) 
    {
        return Excel::download(new ShowInExport($rec_num), 'in_show.xlsx');
    }
    }

