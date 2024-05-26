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
			<form action="{{route('out.cart.update')}}" method="POST">
								@csrf
								@if($carts)
									@foreach($carts as $key=>$cart)
									@php
									$photo=explode(',',$cart->product['photo']);
									@endphp

							     <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
								  <div class="mr-1"><img class="rounded" src="{{asset($photo[0])}}" alt="{{$photo[0]}}" width="70"></div>
								   <div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">{{$cart->product['title']}}</span>
								  <div class="d-flex flex-row product-desc">
									@php 
											$cat = Helper::getAllCategory();
											$categoryId = $cart->product_id;
											
											$category = $cat->find($categoryId);
											$stock1 = DB::table('store1s')->select('stock')->where('pro_id', $cart->product_id)->first();
                    						$stock2 = DB::table('store2s')->select('stock')->where('pro_id', $cart->product_id)->first();
											@endphp
							       {{-- <div class="size mr-1"><span class="text-grey">الفئة</span><span class="font-weight-bold">&nbsp;{{ $category->title }}</span></div> --}}
							      </div>
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
									@if (Auth()->user()->region == 'stoke1')
										<input type="hidden" name='stock' value="">
									@else
										<input type="hidden" name='stock' value="">
									@endif
									<div class="button plus">
										<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
											<i class="ti-plus"></i>
										</button>
									</div>
								  </div>
								
                                 </div>
								 <div class="d-flex align-items-center">
									<a href="{{route('out.cart-delete',$cart->id)}}">
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
			<form class="form" method="POST" action="{{route('out.cart.order')}}">
				@csrf
				<div class="row"> 

					<div class="col-lg-8 col-12">
						<div class="checkout-form">
							<h2 style="font-family: 'Tajawal';font-size: 22px;">الرجاء ادخال كافة البيانات المطلوبة </h2>
							<hr>
							<script>
								function toggleTabs() {
									var orderName = document.getElementById('order_name').value;
									var recNumTab = document.getElementById('rec_num_tab');
									var custTab = document.getElementById('cust_tab');
									var shipNumTab = document.getElementById('ship_tab');
									var contNumTab = document.getElementById('cont_num_tab');
									var envNumTab = document.getElementById('env_name_tab');
									var receNumTab = document.getElementById('rece_date_tab');
									var recipientNumTab = document.getElementById('recipient_tab');
									var custNumTab = document.getElementById('cust_num');
									var otherTabs = document.querySelectorAll('.tab');
							
									// Hide all tabs
									otherTabs.forEach(tab => tab.style.display = 'none');
							
									// Show the tab based on the selected option
									if (orderName === 'بيع') {
										custTab.style.display = 'block';
										custNumTab.style.display = 'block';
										shipNumTab.style.display = 'block';
										receNumTab.style.display = 'block';
										recipientNumTab.style.display = 'block';
										notes_tab.style.display = 'block';
									} else if(orderName === 'اعادة تعيئة') {
										recNumTab.style.display = 'block';
										recipientNumTab.style.display = 'block';
										custTab.style.display = 'block';
										custNumTab.style.display = 'block';
										shipNumTab.style.display = 'block';
										receNumTab.style.display = 'block';
									} else if(orderName === 'شحن') {
										recipientNumTab.style.display = 'block';
										shipNumTab.style.display = 'block';
										receNumTab.style.display = 'block';
										custNumTab.style.display = 'block';
										custTab.style.display = 'block';
									}else if(orderName === 'عهدة') {
										recipientNumTab.style.display = 'block';
										custNumTab.style.display = 'block';
										custTab.style.display = 'block';
										receNumTab.style.display = 'block';
										notes_tab.style.display = 'block';
									}else if(orderName === 'تجربة') {
										custTab.style.display = 'block';
										shipNumTab.style.display = 'block';
										recipientNumTab.style.display = 'block';
										custNumTab.style.display = 'block';
										receNumTab.style.display = 'block';
									}
									else if(orderName === 'هدايا') {
										custTab.style.display = 'block';
										shipNumTab.style.display = 'block';
										recipientNumTab.style.display = 'block';
										custNumTab.style.display = 'block';
										receNumTab.style.display = 'block';
									}
								}
							</script>
							<!-- Form -->
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12" id='mySelect'>
									<div class="form-group">
										<label>نوع الاخراج </label>
										<select name="order_name" id="order_name" required onchange="toggleTabs()">
											<option value="">select</option>
											<option value="عهدة">عهدة</option>
											<option value="بيع">بيع</option>
											<option value="اعادة تعيئة">اعادة تعيئة</option>
											<option value="شحن">شحن</option>
											<option value="هدايا">هدايا</option>
											<option value="تجربة">تجربة</option>

										</select>
									</div>
								</div>
								<div class="tab" id="rec_num_tab" style="display: none;">
									<div class="col-lg-12 col-md-6 col-12">
										<div class="form-group">
											<label>  رقم ايصال الاخراج  </label>
											<input type="number" name="rec_num" value="{{old('rec_num')}}">
										</div>
									</div>
								</div>
								<div class="tab" id="env_name_tab" style="display: none;">
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>اسم المندوب </label>
										<input type="text" name="env_name" placeholder="" value="{{Auth()->user()->name}}">
									
									</div>
								</div>
							</div>
							<div class="tab" id="cust_tab" style="display: none;">
								<div class="col-lg-12 col-md-6 col-12" id="mydiv">
									<div class="form-group">
										<label>اسم الزبون/المستلم </label>
										<input type="text" name="cust" id="cust" value="{{old('cust')}}">
									</div>
								</div>
						</div>
						<div class="tab" id="cust_num" style="display: none;">
							<div class="col-lg-12 col-md-6 col-12" id="mydiv">
								<div class="form-group">
									<label>رقم الهاتف</label>
									<input type="number" name="cust_num" id="cust_num" value="{{old('cust_num')}}">
								</div>
							</div>
					</div>
								<div class="tab" id="rece_date_tab" style="display: none;">
									<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>تاريخ الاخراج<span>*</span></label>
										<input type="date" name="rece_date" placeholder="" value="{{old('rece_date')}}">
									
									</div>
								</div>
							</div>
							<div class="tab" id="recipient_tab" style="display: none;">
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>ملاحظات  </label>
										<input type="text" name="recipient" placeholder="" value="{{old('recipient')}}">
									
									</div>
								</div>
							</div>
							<div class="tab" id="cont_num_tab" style="display: none;">
								<div class="col-lg-12 col-md-6 col-12">
									<div class="form-group">
										<label>رقم سند التسليم  </label>
										<input type="number" name="cont_num" value="{{old('cont_num')}}">
										
									</div>
								</div>
							</div>
								<div class="tab" id="ship_tab" style="display: none;">	
								<div class="col-lg-12 col-md-6 col-9" >
									<div class="form-group">
										<label>الشحن </label>
										@if(count(Helper::shipping())>0)
										<select name="shipping_id" class="nice-select">
											<option value="">اختر وجهة</option>
											@foreach(Helper::shipping() as $shipping)
											<option value="{{$shipping->id}}" class="shippingOption">{{$shipping->type}}</option>
											@endforeach
										</select>
									@else 
										<span style="font-family: 'Tajawal';font-size: 12px;">لا يوجد مناطق</span>
									@endif
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
								<h2 style="font-family: 'Tajawal';font-size: 12px;">الاجماليات: </h2>
								<div class="content">
									<ul>
										<li class="shipping" style="font-family: 'Tajawal';font-size: 12px;">
											اجمالي الكمية : {{Helper::totalOutCart(Auth()->user()->id,$order_type)}}
									
										</li>												
						
									</ul>
								</div>
							</div>
							<!--/ End Order Widget -->
							<!-- Order Widget -->
							@if($carts)
							@foreach($carts as $key=>$cart)
							<input type="hidden" name="product[]" value="{{$cart->product['title']}}">
							<input type="hidden" name="pro_id[]" value="{{$cart->product['id']}}">
							<input type="hidden" name="cart_id[]" value="{{$cart->id}}">
							<input type="hidden" name="user_id" value="{{Auth()->user()->id}}">
							<input type="hidden" name="status" value="process">
							<input type="hidden" name='store' value="{{Auth()->user()->region}}">
							<input type="hidden" name="order_type" value="{{$order_type}}">
							<input type="hidden" name="quantity[{{$key}}]"  value="{{$cart->quantity}}">
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
	</script>
	
	<script type="text/javascript">
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
