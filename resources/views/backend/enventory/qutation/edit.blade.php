@extends('backend.layouts.master')

@section('title','kkk')

@section('main-content')
<h1 style="margin-right: 5%;text-align: right">بيانات الحركة</h1>
  <hr>
  <div class="container">
    <form action="{{route('qutation.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
        <input type="date" name="delevery_date"   value="{{$order->delevery_date}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">وقت التسليم <span>*</span></label>
       @error('delevery_date')
          <span class='text-danger'>{{$message}}</span>
        @enderror
        <input type="text" name="time_valided"   value="{{$order->time_valided}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">مدة العرض  <span>*</span></label>
        @error('time_valided')
          <span class='text-danger'>{{$message}}</span>
        @enderror
      
        <input type="text" name="payments_terms" value="{{$order->payments_terms}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;text-align: right;">  طريقة الدفع  </label>
        @error('payments_terms')
          <span class='text-danger'>{{$message}}</span>
        @enderror
  
        <input type="text" name="qout_type" value="{{$order->qout_type}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">نوع العرض  </label>
        @error('qout_type')
          <span class='text-danger'>{{$message}}</span>
        @enderror

        <input type="text" name="customer" value="{{$order->customer}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">اسم الزبون </label>
        @error('customer')
          <span class='text-danger'>{{$message}}</span>
        @enderror

        <input type="text" name="title" value="{{$order->title}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">العنوان </label>
        @error('title')
          <span class='text-danger'>{{$message}}</span>
        @enderror

        <input type="text" name="guarantee" value="{{$order->guarantee}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">الضمان </label>
        @error('guarantee')
          <span class='text-danger'>{{$message}}</span>
        @enderror

        <input type="number" name="discount" value="{{$order->discount}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">السعر بعد الحسم </label>
        @error('discount')
          <span class='text-danger'>{{$message}}</span>
        @enderror
        @php
        $user = DB::table('users')->where('id', $order->user_id)->first();
        @endphp
        <input type="text" name="user_id" value="{{$user->name}}" disabled>
        <label  style="font-family: 'Tajawal';font-size: 22px;">البائع </label>
        @error('discount')
          <span class='text-danger'>{{$message}}</span>
        @enderror
        <input type="text" name="created_at" value="{{$order->created_at}}" disabled>
        <label  style="font-family: 'Tajawal';font-size: 22px;">التاريخ</label>
    

<h1 style="text-align: right">المواد</h1>
<hr>
  @foreach ($details as $detail)
  <div class="row">
  @php
  $product = DB::table('products')->where('id', $detail->pro_id)->first();
  @endphp
    <div class="col-lg-6 col-md-6 col-12">
      <div class="form-group">
        <input type="number" name="quantity[]"required value="{{$detail->quantity}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">الكمية  </label>
        <input type="number" name="price[]"required value="{{$detail->price}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">الحسم  </label>
        <input type="number" name="pro_dscont[]"required value="{{$detail->pro_dscont}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;"> السعر بعد الحسم   </label>
        <input type="text" name="prod_notes[]"required value="{{$detail->prod_notes}}">
        <label  style="font-family: 'Tajawal';font-size: 22px;">ملاحظات  </label>
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
  <input type="hidden" name="pro_id[]" value="{{ $product->id}}">
  <input type="hidden" name="product[]"   value="{{$detail->product}}">
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
