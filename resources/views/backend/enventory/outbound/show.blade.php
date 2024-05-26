@extends('backend.layouts.master')

@section('title','Order Detail')
<meta name="viewport" content="width=device-width, initial-scale=1">

@section('main-content')
<div class="card">
  </h5>
  <div class="card-body">
    {{-- @if($order) --}}
    @if ($order)
   
    <a href="{{route('export_outbound_show', $order->id)}}" class="btn btn-danger btn-sm float-right" style="margin-left: 1%;" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-export"></i> تصدير</a>
     @endif
    <table class="table table-striped table-hover" style="width: 100%; overflow-x: auto;">
       
        <thead style="width: 100%; overflow-x: auto;">
         <tr >
            <th>الرقم</th>
            <th>تاريخ الاخراج </th>  {{-- //time stamp--}}
            <th >تاريخ الاخراج الفعلي  </th>
            <th>رقم ايصال الاخراج </th>
            </tr></thead>
            <tr>
              <td>{{$order->id}}</td>
              <td>{{$order->created_at}}</td>
              <td>{{$order->rece_date}}</td>
              <td>{{$order->rec_num}}</td>
              
        </tr>  
       </table> 
       <hr>
       <table  class="table table-striped table-hover">
        <thead> 
            <tr>
            <th>نوع الاخراج </th>
           
            @if($order->recipient)
            <th>المستلم  </th>
            @endif
            @if($order->env_name)
            <th>اسم المندوب   </th>
            @endif
           
            <th>رقم سند التسليم </th>

            @if($order->cust)
            <th>اسم الزبون  </th>
            @endif

            @if($order->cust_num)
            <th>رقم الهاتف</th>
            
            @endif
            @if($order->shipping_id)
            <th>وجهة الشحن   </th>
            
            @endif
            <tbody>
        
                <tr>
                    @if($order->order_name)
                        <td>{{ $order->order_name }}</td>
                    @endif
                    @if($order->recipient)
                        <td>{{ $order->recipient }}</td>
                    @endif
                    @if($order->env_name)
                        <td>{{ $order->env_name }}</td>
                    @endif
                        <td>{{ $order->rec_num }}</td>
            
                    @if($order->cust)
                        <td>{{ $order->cust }}</td>
                    @endif

                    @if($order->cust_num)
                    <td>{{ $order->cust_num }}</td>
                     @endif
                    {{-- _________________________________________________________________________________ --}}
                    @if($order->shipping_id)
                    @php    
                    $shipping = DB::table('shippings')->where('id', $order->shipping_id)->first(); 
                    
                    @endphp
                            @if($order->cust)
                            <td>{{ $shipping->type}}</td>
                        @endif
                @else
                        <td></td>
                        
                    @endif
                {{-- _________________________________________________________________________________________ --}}
            
                </tr>
              
          </tbody>
    
</tr> 
        </table>
        <hr></div>
        <div class="card-body">
    <table class="table table-striped table-hover">
        
      <thead>
        <tr>
            <th>اسم المادة </th>
            <th></th>
            <th>الكيمة </th>
            <th>نوع المادة </th>
          
        </tr>
      </thead>
      <tbody>
          @foreach ($details as $detail)
          @php 
          $cat = Helper::getAllCategory();
            $product = DB::table('products')->where('id', $detail->pro_id)->first();
                $product_id = $product->id;
                $categoryId = $product->cat_id;
                $category = $cat->where('id', $categoryId)->first();
            @endphp
        <tr>
            <td>{{$product->title}}</td>
            <td></td>
            <td>{{$detail->quantity}} </td>
            <td>{{$category->title}}</td>
            <td>
            </td>
        </tr>
         @endforeach
      </tbody>
    
    </table>
</div>

    @if (auth()->user()->role != 'envoy' && $order->status == 'process')
    <form action="{{route('outorder.update',$order->id)}}" method="POST">
        @csrf
        @method('PATCH')
    <div class="form-group" style="margin: 3%">
        <label for="status">حالة الطلب  :</label>
        <select name="status" id="se" class="form-control" >
         <option value="done"  {{(($order->status=='done')? 'selected' : '')}}>Done</option> 
        </select>
           <input name="order_type" type="hidden"value='{{$order->order_type}}'>
        </div>
      <button type="submit" class="btn btn-danger" style="margin: 1%">تحديث</button><hr>
    </form>
    @endif

{{-- <hr>
    <div style="display: flex;"style>
      <table >
          <tr>
            @php
                  $totalQuantity = Helper::getTotalQuantityAndOrder($order->id);
            @endphp
              <td>{{$totalQuantity}} :اجمالي </td>
          </tr>
      </table>
  </div> --}}
 
</div>
    
    
    
  

@endsection

@push('styles')
<style>
   table {
            width: 100%;
            overflow-x: auto;
            flex-direction: row;
            
        }
        th, td {
            white-space: nowrap;
            text-align: center;
            font-family: 'Tajawal';
            font-size: 22px;
        }
    .order-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4 {
        text-decoration: underline;
    }
    label{font-family: 'Tajawal';font-size: 22px;
  margin-left: 2%;}
  @media only screen and (max-width: 768px) {
      table { 
         overflow-x: auto;
        white-space: nowrap;
          font-family: 'Tajawal';
          font-size: 12px;/* Adjust font size for smaller screens */
      }
      th, td {
          padding: 5px;
          font-size: 12px; /* Adjust padding for table cells */
      }
      .form-group {
          margin: 2%; /* Adjust margin for form elements */
      }
      .card {
        overflow-x: auto; /* Enable horizontal scrolling */
        max-width: 100%; 
      }
  }


</style>
@endpush
