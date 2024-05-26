@extends('backend.layouts.master')

@section('title','Order Detail')
<meta name="viewport" content="width=device-width, initial-scale=1">

@section('main-content')
<div class="card">
  </h5>
  <div class="card-body">
    @if ($orders)
 
    <a href="{{route('export_inbound_show',  $orders->id)}}" class="btn btn-danger btn-sm float-right" style="margin-left: 1%;" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-export"></i> تصدير</a>
  
     @endif
    <table class="table table-striped table-hover">
     <thead>
          <th>الرقم </th>
          <th>تاريخ الادخال </th>
          <th>رقم ايصال الادخال </th>
          <th>المستلم</th>
              <th>المصدر</th>
      </thead>
                <tr>
                <td>{{$orders->id}}</td>
                <td>{{$orders->rece_date}}</td>
                <td>{{$orders->rec_num}}</td>
                <td>{{$orders->recipient}}</td>
                <td>{{$orders->deliverer}}</td>

            </tr> 
      <thead>
        <tr>
            <th>اسم المادة </th>
            <th></th>
            <th>الكيمة </th>
            <th>نوع المادة </th>
        </tr>
      </thead>
      <tbody>
          @foreach ($details as $order)
        <tr>
            @php 
            $product = Helper::getAllProducty();
            $cat = Helper::productCategoryList();
            $product = $product->where('id', $order->pro_id)->first();
            $product_id = $product->id;
            $categoryId = $product->cat_id;
            $category = $cat->where('id', $categoryId)->first();
            @endphp
            <td>{{$product->title}}</td>
            <td></td>
            <td>{{$order->quantity}} </td>
            <td>{{$category->title}}</td>
        </tr>
         @endforeach
      </tbody>
    
    </table>
    
  </div>
</div>
    <hr>
    {{-- <div style="display: flex;">
      <table >
          <tr>
              <td>lable اجمالي الاجهزة</td>
              <td>مجموع الاجهزة</td>
          </tr>
          <!-- يمكنك إضافة صفوف إضافية حسب الحاجة -->
 
          <tr>
              <td>اجمالي الزيوت lable</td>
              <td>مجموع الزيوت</td>
          </tr>
          <!-- يمكنك إضافة صفوف إضافية حسب الحاجة -->
      </table>
  </div> --}}
  

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
            font-family: 'Tajawal';font-size: 12px;/* Adjust font size for smaller screens */
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
