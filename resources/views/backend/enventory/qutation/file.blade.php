<
@extends('backend.layouts.maa')
<link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href=" https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    @stack('styles')
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!DOCTYPE html>

<body>


    <div class="card-body">
    <a href="{{route('pdf', $orders->id)}}" class="btn btn-danger btn-sm float-left export-btn" style="margin-left: 30px;" data-toggle="tooltip" data-placement="bottom" ><i class="fas fa-export"></i> PDF</a> 

<div class="container mt-5">

  <div class="">
    <div class ="row"style="background-color:#333F50;margin:3">

  <div class="col-md-4"style="background-color:#333F50; margin-top: 30px;"  >DATE: {{$orders->created_at}}  <br>
  QUT NUM: {{$orders->qut_num}} <br> NAME:  {{$orders->customer}} </div>
    <div class="col-md-4 ms-auto" style="margin-top: 10px;  text-align: center;
  align-items: center; "> 
   @if($orders->title == "1")
    عرض سعر
    <br>
   Qutation
    @elseif($orders->title == "2")
    عرض خدمة تعطير
    <br>
    Rental Quotation
   @elseif($orders->title == "3")
   عرض خدمة استبدال
   <br>
    Device replacement Quotation
    @endif
    

    
    </div>
    
  </div>
  <div class="text-center mb-4 H-2">
  <img src="{{asset('templets\Q.png')}}" alt="" style="height:112px; width:1024px;">

   
  </div>
  <div class="table-responsive">

  <table class="table">
    <thead style="text-align: center;
  align-items: center; ">
      <tr >
        <th></th>
        <th >SALESPERSON <br>
          البائع المسؤول</th>
          <th></th>
          <th></th>

        <th >DELIVERY DATE<br>
          وقت التسليم</th>
<th></th>
<th></th>
          <th>PAYMENT TERMS<br>
            طريقة الدفع
            </th>
            <th></th>
            <th>OFFER VALIDITY<br>
              مدة العرض
              </th>
              <th></th>
              <th></th>
        
       </thead>
        <tbody>
       <tr>
        <td></td>
        @php
        $user = DB::table('users')->where('id', $orders->user_id)->first();
        @endphp
   
        <td>{{$user->name}}</td>
        <td></td>
        <td></td>
        <td> {{$orders->delevery_date}}</td>

        <td></td>
        <td></td>
        <td> {{$orders->payments_terms}}</td>

        <td></td>
        <td> {{$orders->time_valided}}</td>

        <td>  </td>
        <td>  </td>


      </tr>
    </tbody>
  
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">DESCRIPTION <br>الوصف </th>
        <th scope="col">PIC <br>الصورة </th>
        <th scope="col">QTY <br>الكمية 
        </th>
        <th scope="col">PRICE <br>السعر </th>
        <th scope="col">DISCOUNT  <br>الحسم</th>
        <th scope="col">PRICE AFTER DISCOUNT <br>السعر بعد الحسم</th>
        <th scope="col">NET UNIT PRICE <br>صافي السعر </th>
        <th scope="col">VAT % <br>ضريبة القيمة المضافة</th>
        <th scope="col"> SUP TOTAL <br>الاجمالي الفرعي </th>
        
        <th scope="col">TOTAL PRICE <br>الاجمالي </th>
        <th scope="col">NOTE <br>ملاحظات </th>
      </tr>
    </thead>
    @foreach ($details as $detail)
          @php 
            $cat = Helper::getAllCategory();
              $product = DB::table('products')->where('id', $detail->pro_id)->first();
                  $product_id = $product->id;
                  $categoryId = $product->cat_id;
                  $category = $cat->where('id', $categoryId)->first();
              @endphp
    <tbody>
      <tr>
        <td>1</td>
        <td>{{$detail->vate}}</td>
        <td><img src="{{asset($product->photo)}}" alt="" style="height:30px;width:20pxs"></td>

        <td>{{$detail->quantity}} </td>
        <td>{{$detail->price}}</td>
        <td>{{round((($detail->price-$detail->pro_dscont)/$detail->price)*100)}}%</td>
        <td>{{$detail-> pro_dscont}}</td>
        <td>{{ number_format(($detail-> pro_dscont/115*100),2)}}</td>

        <td>{{number_format($detail-> pro_dscont-($detail-> pro_dscont/115*100),2)}}</td>
        <td>{{(($detail-> pro_dscont-($detail-> pro_dscont/115*100))+($detail-> pro_dscont/115*100))}}</td>
        <td>{{(($detail-> pro_dscont-($detail-> pro_dscont/115*100))+($detail-> pro_dscont/115*100))* $detail->quantity}}</td>

        <td>{{$detail->notes}}</td>


      </tr>
      @endforeach

      </tbody>
  </table>
  </div>
<hr>

<br>

<div class="table-responsive">

    <table class="Total" >
    @php
  $totalPriceSum = 0; // Initialize the sum variable
  $totalvat = 0; // Initialize the sum variable
  @endphp

@foreach ($details as $detail)
    @php
    // Assuming $detail->price * $detail->quantity represents the "TOTAL PRICE" for each item
    $totalPriceSum +=((($detail-> pro_dscont-($detail-> pro_dscont/115*100))+($detail-> pro_dscont/115*100))* $detail->quantity); // Accumulate the total price
    $totalvat +=($detail-> pro_dscont-($detail-> pro_dscont/115*100)); // Accumulate the total price
 @endphp
@endforeach
        <thead >
          
      <tr>
        <td colspan="6" class="text-right">Item Total:</td>
        <td>{{number_format(($totalPriceSum-$totalvat),2)}}</td>
      </tr></thead>
      <tbody>
      <tr>
        <td colspan="6" class="text-right">VAT (15%):</td>
        <td>{{number_format($totalvat,2)}}</td>
      </tr>
     </tbody>
      <tfoot>
      <tr> 

        <td colspan="6" class="text-center font-weight-bold">Total:</td>
        <td>{{$totalPriceSum}}</td>
      </tr>
    </tfoot>
     

<!-- Display the total price sum -->

  </table>
  </div>
  <br><br><br><br><br>


  <footer>
  <div class="mb-3">
  <p>   @if($orders->guarantee == "1" )
  مدة ضمان الأجهزة سنتين شاملة الصيانة أو الاستبدال في حالة توفر الأصل.
وينتهي ضمان الفاتورة في حالة سوء الاستخدام أو استخدام عطر آخر غير معتمد من الشركة.


    @else.
@endif
     @if($orders->guarantee == "1" )
   <br>  The warranty period for the devices's 2 years, including maintenance or replacement if the original is available.The invoice warranty ends in the event of misuse or use of another perfume not approved by the company.  
    @else.
@endif 
</p><p>رقم حساب البنك الرياض: SA45000000003157779900 <br>Riyad Bank, account number: SA5420000002581567279940 </p>
  </div>
  
</footer>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>


@push('styles')
<style>
@media(max-width: 768px) {
    /* قم بوضع التنسيقات هنا التي تريد تطبيقها على الجدول على الشاشات الصغيرة */

    /* للعناوين في الجدول */
    table th {
        font-size: 14px;
    }

    /* للخلايا في الجدول */
    table td {
        font-size: 14px;
    }

    /* لضبط العرض والارتفاع */
    table {
        width: 100%;
    }

    /* للقوائم */
    .table-responsive {
        overflow-x: auto;
    }
    .H-2 img {
        max-width: 362px;
        height: 120PX;
    }
}
</style>
<style>
    
    body {
  background-color: #f4f4f4;
  font-family: 'Tajawal';font-size: 12px;
}

.container {
  background-color: #F1EFF3;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding-left: 2px;
  padding-right: 2px;
  padding-top: 10px;




}.Total thead td{
border:  #000103;
border-style:double; 
border-top: 0cap;
border-left: 0cap;
border-right: 0cap;
}

.Total tfoot td{
  background-color: rgb(199, 194, 194);
  text-align: left;
}
.Total{
  float: right;
  font-size: 15px;
  margin-right: 15px;  
}
.col-md-4{
  margin-left: 50px;
   margin-right: 90px; 

   background-color: #333F50;
   color: #f4f4f4;
   font-family: 'Tajawal';
   font-size: 12px;

}
.col-md-4.ms-auto{
  margin-left: 50px; 
  margin-right: 90px;
   background-color: #333F50;
   color:#ddd ;
   font-family: 'Tajawal';
   font-size :35px;;
}
h3{
  color:#ddd;

  font-size: 12px;
  text-align: left;
}
.text-center.mb-4.H-1{  
  background-color: #333F50;

}
p{
  text-align: center;
}
.text-center {
  text-align: center;
}

.H-1 {
  display: flex;
  justify-content: space-between;
}

.H-1 .row {
  display: flex;
  flex-direction: column;
}
footer{
  width: 100%;
  background-color: #333F50;
  color: #ddd;}
img {
  height: 100%;
  width: 100%;
}
.mb-3.acn{
  text-align: center;}
.table.th{
  background-color: #333F50;
  color: #ddd;
text-wrap:wrap;
  text-align: center;
  align-items: center;
font-size: 50%;


}
th{
  background-color: #333F50;
  color: #ddd;
text-wrap:wrap;
  text-align: center;
  align-items: center;
font-size: 90%;


}

h2 {
 margin: 0px;
  padding-bottom: 10px;
  margin-right: 100px;
  color: #f4f4f4;
  text-align: right;


}

.table {
  margin-top: 20px;
}

.table th, .table td {
  text-align: right;
}



.text-right {
  text-align: right;
}

.font-weight-bold {
  font-weight: bold;
}


</style>
@endpush