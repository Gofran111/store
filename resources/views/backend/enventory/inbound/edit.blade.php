@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<h1 style="margin-right: 5%;text-align: right">بيانات الحركة</h1>
  <hr>

  <div class="container">
    <form action="{{route('inorder.update',$orders->id)}}" method="POST">
      @csrf
      @method('PATCH')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
       
        <input type="number" name="rec_num"   value="{{$orders->rec_num}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">رقم ايصال الادخال <span>*</span></label>
        @error('rec_num')
          <span class='text-danger'>{{$message}}</span>
        @enderror
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
        @if ($orders->deliverer =='store1s')
        <label>الرياض</label>
        @elseif($orders->deliverer =='store2s')
        <label>الغربية</label>
        @elseif($orders->deliverer =='store3s')
        <label>سرداب</label>
        @elseif($orders->deliverer =='store4s')
        <label>عليا</label>
        @else
        <label>خارجي</label>
        @endif
        <label  style="font-family: 'Tajawal';font-size: 22px;"> : المصدر</label>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
        <input type="date" name="rece_date" value="{{$orders->rece_date}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;text-align: right;">تاريخ الاستلام الفعلي </label>
        @error('rece_date')
          <span class='text-danger'>{{$message}}</span>
        @enderror
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
        <input type="text" name="recipient" value="{{$orders->recipient}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">المستلم </label>
        @error('recipient')
          <span class='text-danger'>{{$message}}</span>
        @enderror
      </div>
    </div>
  
    
  </div>    

<h1 style="text-align: right">المواد</h1>
<hr>
  @foreach ($details as $key=>$order)
  <div class="row">
     @php
        $product = DB::table('products')->where('id', $order->pro_id)->first();
        @endphp
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
        <input type="text" name="quantity[{{$key}}]"required value="{{$order->quantity}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">الكمية  </label>
        <input type="hidden" name="pro_id[]" value="{{$order->pro_id}}">
        {{-- <input type="hidden" name="user_id" value="{{Auth()->user()->id}}"> --}}
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">  
            <label >{{$product->title}}</label>
        <label  style="font-family: 'Tajawal';font-size: 22px;text-align: right;">: اسم المنتج  </label>
      </div>
    </div>
  </div>

 <hr>


    @endforeach
    <button type="submit" class="btn btn-danger"style="margin:10%;margin-left:1%">تحديث</button>
  </form>
</div>



@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
