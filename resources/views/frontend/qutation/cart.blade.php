@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')

	<!-- End Breadcrumbs -->
<body style="background-color: #bbad9e">
	<!-- Shopping Cart -->
	<div class="shopping-cart section"style="background-color: #bbad9e">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
							<form action="{{route('qutation.cart.update')}}" method="POST">
								@csrf
								@if(Helper::getAllProductFromCart())
									@foreach(Helper::getAllProductFromCart() as $key=>$cart)
									@php
									$photo=explode(',',$cart->product['photo']);
									@endphp

							     <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
								  <div class="mr-1"><img class="rounded" src="{{asset($photo[0])}}" alt="{{$photo[0]}}" width="70"></div>
								   <div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">{{$cart->product['title']}}</span>
								  <div class="d-flex flex-row product-desc">
									@php 
											$cat = Helper::getAllCategory();
											$categoryId = $cart->product['cat_id'];
											$category = $cat->find($categoryId);
											
											@endphp
							       <div class="size mr-1"><span class="text-grey">الفئة</span><span class="font-weight-bold">&nbsp;{{ $category->title }}</span></div>
							      </div>
								    </div>
									<div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">السعر </span>
									<input type="number" name="price[{{$key}}]"  value="{{$cart->price}}">
									</div>
									<div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">السعر بعد الحسم </span>
									<input type="number" name="pro_dscont[{{$key}}]"  value="{{$cart->pro_dscont}}">
									</div>
								<div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">ملاحظات</span>
									<input type="text" name="prod_notes[{{$key}}]"  value="{{$cart->prod_notes}}">
									</div>
									<div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">الوصف</span>
									<input type="text" name="vate[{{$key}}]"  value="{{$cart->vate}}">
									</div>
							      <div class="d-flex flex-row align-items-center qty">
								    <div class="input-group">
									<div class="button minus">
										<button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{$key}}]">
											<i class="ti-minus"></i>
										</button>
									</div>
									<input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="100" value="{{$cart->quantity}}">
									<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
								
									<div class="button plus">
										<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
											<i class="ti-plus"></i>
										</button>
									</div>
								  </div>
								
                                 </div>
								 <div class="d-flex align-items-center">
									<a href="{{route('qutation-delete',$cart->id)}}">
										<i class="fa fa-trash mb-1 text-danger"></i></a>
									</div>
							</div>	
									@endforeach
									@endif
											<!--/ End Shopping Summery -->
										</div>
									</div>
									
										<div class="row">
											<div class="col-12">
												<!-- Total Amount -->
												<div class="total-amount">
													<div class="row">
														
														<div class="col-lg-4 col-md-7 col-12">
															<div class="right">
																<div class="button5">
																	<button class="btn float-right" type="submit" style="background-color:black;direction: rtl ;text-align: center;font-family:'Tajawal';font-size: 20px;">تحديث</button>
																</form>  
																<button class="btn" id='check'style="background-color:black;direction: rtl ;text-align: center;font-family:'Tajawal';font-size: 22px;">متابعة </button>	
															</div>
														</div>
													</div>
												</div>
											</div>
											<!--/ End Total Amount -->
										</div>
									</div>
			
		</div>
	</div>
	<!--/ End Shopping Cart -->
{{-- ____________________________________________________________________________________________ --}}
<!-- Start Checkout -->
<section class="shop checkout section" id='appear'style="display:none">
	<div class="container">
	
		<button class="btn"id='close'>X </button>
			<form class="form" method="POST" action="{{route('qutation.order')}}">
				@csrf
				<div class="row"> 

					<div class="col-lg-8 col-12">
						<div class="checkout-form">
							<h2 style="font-family: 'Tajawal';font-size: 22px;">الرجاء ادخال كافة البيانات المطلوبة </h2>
							<hr>
							
							<!-- Form -->
							<div class="row">
							
								<div class="tab" id="notes_tab" >
									<div class="col-lg-12 col-md-6 col-12">
										<div class="form-group">
											<label> مدة العرض </label>
											<input type="text" name="time_valided" value="{{old('time_valided')}}"required>
										</div>
									</div>
								</div>
							<div class="tab" id="cust_tab" >
								<div class="col-lg-12 col-md-6 col-12" id="mydiv">
									<div class="form-group">
										<label>اسم الزبون </label>
										<input type="text" name="customer" id="customer" value="{{old('customer')}}"required>
									</div>
								</div>
						</div>
								<div class="tab" id="rece_date_tab" >
									<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label> وقت التسليم <span>*</span></label>
										<input type="text" name="delevery_date"  value="{{old('delevery_date')}}"required>
									
									</div>
								</div>
							</div>
							<div class="tab" id="recipient_tab" >
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>طريقة الدفع </label>
										<input type="text" name="payments_terms" value="{{old('payments_terms')}}"required>
									
									</div>
								</div>
							</div>
						
							<div class="tab" id="cont_num_tab" >
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>عنوان العرض  </label>
										
												
										<select name="title" id="guarantee" style="font-family:'Tajawal';font-size: 20px;"required>
                <option value="1" >عرض سعر</option>
                <option value="2" style="font-family:'Tajawal';font-size: 20px;"> عرض خدمة تعطير </option>
                <option value="3" style="font-family:'Tajawal';font-size: 20px;"> عرض خدمة استبدال </option>

       
                <!-- Add more options as needed -->
            </select>
									</div>
								</div>
							</div>
							<div class="tab" id="cont_num_tab" >
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>الضمان  </label>
									
										<select name="guarantee" id="guarantee"  style="font-family:'Tajawal';font-size: 20px;"required>
                <option value="1" style="font-family:'Tajawal';font-size: 20px;">لا يوجد ضمان </option>
                <option value="2" style="font-family:'Tajawal';font-size: 20px;">يوجد ضمان</option>
       
                <!-- Add more options as needed -->
            </select>
									</div>
								</div>
							</div>
							</div>
							
							</div>
							<!--/ End Form -->
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="order-details">
							<!-- Order Widget -->
							<div class="single-widget">
								<h2 style="font-family: 'Tajawal';font-size: 14px;">الاجماليات: </h2>
								<div class="content">
									<ul>
										<li style="font-family: 'Tajawal';font-size: 14px;">
											اجمالي الكمية : {{Helper::totalCart()}}
									
										</li>												
										<li  style="font-family: 'Tajawal';font-size: 14px;">
											اجمالي السعر : {{Helper::totalCartPrice()}}
										</li>	
										<li class="totalCartPrice" style="font-family: 'Tajawal';font-size: 12px;">
											<div class="tab" id="cont_num_tab" >
												<div class="col-lg-12 col-md-6 col-12">
													<div class="form-group">
														<label>الحسم الاحمالي  </label>
														<input type="number" name="discount" value="{{old('discount')}}">
														
													</div>
												</div>
											</div>
										</li>	
									</ul>
								</div>
							</div>
							<!--/ End Order Widget -->
							<!-- Order Widget -->
							@if(Helper::getAllProductFromCart())
							@foreach(Helper::getAllProductFromCart() as $key=>$cart)
							{{-- <input type="hidden" name="product[]" value="{{$cart->product['title']}}"> --}}
							<input type="hidden" name="pro_id[]" value="{{$cart->product_id}}">
							<input type="hidden" name="cart_id[]" value="{{$cart->id}}">
							<input type="hidden" name="user_id" value="{{Auth()->user()->id}}">
							<input type="hidden" name="price[{{$key}}]"  value="{{$cart->price}}">
							<input type="hidden" name="vate[{{$key}}]"  value="{{$cart->vate}}">
							<input type="hidden" name="quantity[{{$key}}]"  value="{{$cart->quantity}}">
							<input type="hidden" name="pro_dscont[{{$key}}]"  value="{{$cart->pro_dscont}}">
							<input type="hidden" name="prod_notes[{{$key}}]"  value="{{$cart->prod_notes}}">
							@endforeach
							@endif
							
							<!-- Button Widget -->
							<div class="single-widget get-button">
								<div class="content">
									<div class="button">
										<button type="submit" class="btn">تاكيد</button>
									</div>
								</div>
							</div>
							<!--/ End Button Widget -->
						</div>
					</div>
				</div>
			</form>
		
	</div>
</body>
</section>

<!--/ End Checkout -->
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-
			: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#e7d2c9 !important;
			color:white !important;
		}
		.btn:hover {
		background-color: #f6dddd; /* Change this color to the color you want */
		color: #ffffff; /* Change the text color if needed */
		}

	
		.form-select .nice-select::after {
			top: 14px;
		}
		
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
			$('select.nice-select').niceSelect();
	</script>
	<script>
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}

		$("#check").click(
		function(){
			$("#appear").show();
		}
	);
	$("#close").click(
		function(){
			$("#appear").hide();
		}
	);
	</script>
@endpush	

@endsection
<style>@import url('https://fonts.googleapis.com/css?family=Tajawal');

span{font-family: 'Tajawal';font-size: 12px;}
label{font-family: 'Tajawal';font-size: 22px;}
</style>
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#e7d2c9 !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>


@endpush