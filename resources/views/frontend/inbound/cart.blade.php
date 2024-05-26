@extends('frontend.layouts.master')

@section('title','Cart Page')
@section('main-content')

	<!-- Shopping Cart -->
<body style="background-color: #bbad9e">
	<div class="shopping-cart section"style="background-color: #bbad9e">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<form action="{{route('t_cart_update')}}" method="POST">
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
											$categoryId = $cart->product['cat_id'];
											$category = $cat->find($categoryId);
											@endphp
							       <div class="size mr-1"><span class="text-grey">الفئة</span><span class="font-weight-bold">&nbsp;{{ $category->title }}</span></div>
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
									<input type="hidden" name='store' value="{{$cart->store}}">
									<div class="button plus">
										<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
											<i class="ti-plus"></i>
										</button>
									</div>
								  </div>
								
                                 </div>
								 <div class="d-flex align-items-center action"><a href="{{route('in.cart-delete',$cart->id)}}"><i class="fa fa-trash mb-1 text-danger"></i></a></div>
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

		<!-- Start Checkout -->
		<section class="shop checkout section" id='appear'style="display:none">
			<div class="container">
			
				<button class="btn"id='close'>X </button>
					<form class="form" method="POST" action="{{route('in.cart.order')}}">
						@csrf
						<div class="row"> 
	
							<div class="col-lg-8 col-12">
								<div class="checkout-form">
									<h2  style="font-family: 'Tajawal';font-size: 22px;">الرجاء ادخال كافة البيانات المطلوبة </h2>
									<hr>
								
									<!-- Form -->
									<div class="row">
										<div class="col-lg-6 col-md-6 col-12">
											<div class="form-group">
												<label  style="font-family: 'Tajawal';font-size: 22px;">رقم ايصال الادخال <span>*</span></label>
												<input type="number" name="rec_num" placeholder="" value="{{old('rec_num')}}">
												{{-- @error('rec_num')
													<span class='text-danger'>{{$message}}</span>
												@enderror --}}
											</div>
										</div>
									
										{{--  --}}
										<div class="col-lg-6 col-md-6 col-12">
											<div class="form-group">
												<label  style="font-family: 'Tajawal';font-size: 22px;">تاريخ الاستلام الفعلي <span>*</span></label>
												<input type="date" name="rece_date" placeholder="" value="{{old('rece_date')}}" required>
												{{-- @error('rece_date')
													<span class='text-danger'>{{$message}}</span>
												@enderror --}}
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-12">
											<div class="form-group">
												<label  style="font-family: 'Tajawal';font-size: 22px;">المستلم </label>
												<input type="text" name="recipient" placeholder="" value="{{old('recipient')}}">
												{{-- @error('recipient')
													<span class='text-danger'>{{$message}}</span>
												@enderror --}}
											</div>
										</div>
											<div class="col-lg-6 col-md-6 col-12">
											<div class="form-group">
												<label  style="font-family: 'Tajawal';font-size: 22px;">الوجهة  </label>
												<select name="deliverer" class="nice-select">
													@if($source != 'store1s')
													<option value='store1s'>الرياض</option>
													@endif
													@if($source != 'store2s')
													<option value='store2s'>الغربية</option>
													@endif
													@if($source != 'store3s')
													<option value='store3s'>سرداب</option>
													@endif
													@if($source != 'store4s')
													<option value='store4s'>عليا</option>
													@endif
												</select>
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
										<h2  style="font-family: 'Tajawal';font-size: 22px;">اجماليات الطلبية </h2>
										<div class="content">
											<ul>
											<li style="font-family: 'Tajawal';font-size: 22px;">	{{Helper::totalinCart()}}:	الاجمالي </li>
											</ul>
										</div>
									</div>
									<!--/ End Order Widget -->
									<!-- Order Widget -->
									@if($carts)
									@foreach($carts as $key=>$cart)
									{{-- <input type="hidden" name="product[]" value="{{$cart->product['title']}}"> --}}
									<input type="hidden" name="pro_id[]" value="{{$cart->product_id}}">
									<input type="hidden" name="user_id" value="{{Auth()->user()->id}}">
									<input type="hidden" name='store' value="{{$cart->store}}">
									<input type="hidden" name="cart_id[]" value="{{$cart->id}}">
									<input type="hidden" name="quantity[{{$key}}]"  value="{{$cart->quantity}}">
									@endforeach
									@endif
									
									<!-- Button Widget -->
									<div class="single-widget get-button">
										<div class="content">
											<div class="button">
												<button type="submit" class="btn"  style="font-family: 'Tajawal';font-size: 22px;">تاكيد</button>
											</div>
										</div>
									</div>
									<!--/ End Button Widget -->
								</div>
							</div>
						</div>
					</form>
				
			</div>
		
		</section>
</body>
		<!--/ End Checkout -->
	@push('styles')
		<style>
			.label{ style="font-family: 'Tajawal';font-size: 22px;"}
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
<style>
	@import url('https://fonts.googleapis.com/css?family=Tajawal');

	

body {
font-family: 'Tajawal';font-size: 22px;
}
</style>
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
			font-family: 'Tajawal';font-size: 22px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
			font-family: 'Tajawal';font-size: 22px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;font-family: 'Tajawal';font-size: 22px;
		}
		.form-select {
			height: 30px;
			width: 100%;font-family: 'Tajawal';font-size: 22px;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;font-family: 'Tajawal';font-size: 22px;
		}
		.list li{
			margin-bottom:0 !important;font-family: 'Tajawal';font-size: 22px;
		}
		.list li:hover{
			background:#e7d2c9 !important;
			color:white !important;font-family: 'Tajawal';font-size: 22px;
		}
		.form-select .nice-select::after {
			top: 14px;font-family: 'Tajawal';font-size: 22px;
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
