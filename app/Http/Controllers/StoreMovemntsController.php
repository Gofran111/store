<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\movements_carts;
use App\Models\store_movemnts_orders;
use App\Models\store_movemnts_details;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\User;
use App\Models\store1s;
use App\Models\store2s;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class StoreMovemntsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=store_movemnts_orders::orderBy('id','DESC')->paginate(10);
        // return $orders;
        return view('backend.enventory.outbound.index')->with('orders',$orders);
    }

    public function envoyindex()
    {
        $orders=store_movemnts_orders::orderBy('id','DESC')->paginate(10);
        return view('backend.enventory.envoy.orders')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // dd($request);
        if(empty(movements_carts::where('user_id',auth()->user()->id)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
         $order=new store_movemnts_orders();
         $order->order_type=$request->order_type;
         $order->order_name=$request->order_name;
         $order->rec_num=$request->rec_num;
         $order->env_name=$request->env_name;
         $order->cust=$request->cust;
         $order->cust_num=$request->cust_num;
         $order->rece_date=$request->rece_date;
         $order->cont_num=$request->cont_num;
         $order->shipping_id=$request->shipping_id;
         $order->user_id=$request->user_id;
         $order->notes=$request->notes;
         $order->store=$request->store;
         $stat =$order->save();
        if ($stat) {
            foreach($request->product as $key =>$pro){
                $details = new store_movemnts_details();
                $details->quantity=$request->quantity[$key];
                $details->pro_id = $request->pro_id[$key];
                $details->ord_id = $order->id;
                $details->save();
            if (Auth()->user()->role == 'envoy') {
                $order->status=$request->status;
                $status=$order->save();
              }else{
                if (Auth()->user()->region == 'store1') {
                    $store2 = store1s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store1s();
                        $store2-> pro_id = $details->pro_id;
                    }
                } else{
                    $store2 = store2s::where('pro_id',$details->pro_id)->first();
                    if ($store2 == null) {
                        $store2 = new store2s();
                        $store2-> pro_id = $details->pro_id;
                    }
                }
                if ($order->order_type == 'in') {
                    $store2->stock += $request->quantity[$key];
                }else{
                    $store2->stock -= $request->quantity[$key];
                }
                $status= $store2->save();
                }
            }
        }
        if($status){ 
                foreach($request->cart_id as $key =>$cart_id){
                $cart = movements_carts::find($cart_id);
                        if ($cart) {
                            $cart->delete();}
                }
                session()->forget('inbound_carts');
                $admins = User::where('role','admin')->get();
                $users = User::where('role','user')->where('region',Auth()->user()->region)->get();
                $details=[
                    'title'=>auth()->user()->name ."  طلب جديد من المندوب",
                    'actionURL'=>  route('env.order.index'),
                    'fas'=>'fas fa-comment'
                ];
                foreach($admins as $admin){
                    Notification::send($admin, new StatusNotification($details));
                }
                if ($users) {
                    $details_users=[
                        'title'=>auth()->user()->name ."  طلب جديد من المندوب",
                        'actionURL'=>  route('out.order.index'),
                        'fas'=>'fas fa-comment'
                    ];
                    foreach ($users as $user) {
                        Notification::send($user, new StatusNotification($details_users));    
                    }
                }    
                request()->session()->flash('success','تم اكمال الطلب بنجاح');
                return redirect()->route('env.order.index');
                        
            }else{
                request()->session()->flash('success','Fail order');
                return redirect()->back();
            }
    } 
  
    public function show($id)
        {
            // return $id;
            $order = store_movemnts_orders::find($id);
            $details = store_movemnts_details::where('ord_id', $order->id)->get();
            // return $details;
            return view('backend.enventory.outbound.show')->with('order', $order)->with('details', $details);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $order=store_movemnts_details::where('ord_id', $id)->get();
        $status = store_movemnts_orders::find($id);
        $status->status=$request->status;
        $status->save();
        //  dd( $request);
            foreach($order as $key =>$ord){
                $data=$ord->pro_id; 
                if (Auth()->user()->region == 'store1') {
                    $store2 = store1s::where('pro_id',$data)->first();
                    if ($store2 == null) {
                        $store2 = new store1s();
                        $store2-> pro_id = $data;
                    }
                } else{
                    $store2 = store2s::where('pro_id',$data)->first();
                    if ($store2 == null) {
                        $store2 = new store2s();
                        $store2-> pro_id = $data;
                    }
                }
                if ($request->order_type == 'in') {
                    $store2->stock +=$ord->quantity;
                }else{
                    $store2->stock -=$ord->quantity;

                }
                    $store2->save();
                    $status= $ord -> save();
                 }
        if($status){
            request()->session()->flash('success','تم تحديث طلب بنجاح');
        }
        else{
            request()->session()->flash('error','خطأ بالطلب');
        } 
        return redirect()->route('out.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = store_movemnts_orders::where('id', $id)->first();
        $details=store_movemnts_details::where('ord_id', $id)->get();
        $status = $orders->delete();
        // dd( $details);
        if($status){
            foreach($details as $detail){
              $old_qu = $detail->quantity;
                if ($orders->store == 'store1') {
                    $store = store1s::where('pro_id',$detail->pro_id)->first();
                } else if ($orders->store == 'store2'){
                    $store = store2s::where('pro_id',$detail->pro_id)->first();
                } 
                if ($orders->order_type == 'in') {
                    $store->stock -=$old_qu;
                }else{
                    $store->stock +=$old_qu;
                }
                $store->save();
                $status = $detail->delete();
            } 
            
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->back();
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function destroyenv( $id)
    {   
         $orders = store_movemnts_orders::where('id', $id)->first();
        $details=store_movemnts_details::where('ord_id', $id)->get();
        $status = $orders->delete();
        if($status){
            foreach($details as $order){
                $status = $order->delete();
            } 
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->back();
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $order=store_movemnts_orders::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.enventory.outbound.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    
    public function checkbox(Request $request, $id){
        $admins=User::where('role','admin')->get();
        $details=[
            'title'=> auth()->user()->name . " تم استلام الطلب",
            'actionURL'=> route('out.order.show',$id),
            'fas'=>'fa-file-alt'
        ];
        foreach($admins as $admin){
            Notification::send($admin, new StatusNotification($details));
        }
        $checks =  store_movemnts_orders::find($id);
             $checks->ok = $request->ok ;
             $checks->save();
   return redirect()->back();
    }
  }

