
<!DOCTYPE html>
<html lang="zxx">
<head>
    @include('frontend.layouts.head')   
    <title>Mr scents || Login Page</title>

    <!-- Add viewport meta tag for responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="js" style="background-color:#bbad9e">
    
    <!-- Include preloader if necessary -->

    @include('frontend.layouts.notification')

    <section class="shop login section" style="background-color:#bbad9e">
    
        <div class="container">
            <div class="row"> 
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <div class="logo" style="text-align: center; margin-bottom: 10px;">
                            <img src="/storage/image/logo.png" alt="شعار الشركة" style="max-width: 100%;">
                        </div>
                        <hr>

                        <!-- Form -->
                        <form class="form" method="post" action="{{route('login.submit')}}">
                            @csrf
                            <div class="form-group">
                                <label style="direction: rtl; text-align: right;">الإيميل<span>*</span></label>
                                <input type="email" name="email" placeholder="" class="form-control" required="required" value="{{old('email')}}">
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label style="direction: rtl; text-align: right;">كلمة المرور <span>*</span></label>
                                <input type="password" name="password" placeholder="" class="form-control" required="required" value="{{old('password')}}">
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group login-btn">
                                <button class="btn btn-primary btn-block" type="submit" style="font-family: 'Tajawal'; font-size: 22px;">تسجيل الدخول</button>
                            </div>
                            <div class="form-group" style="direction: rtl; text-align: right; display: flex; align-items: center;">
                            <label class="form-check-label" for="remember-me" style="font-size: 18px; margin-right: 10px;">حفظ كلمة المرور</label>
                            <input type="checkbox" name="news" class="form-check-input" id="remember-me" style="transform: scale(0.5); direction: rtl; text-align: right;margin:0px;">
                        </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->

</body>
@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>
<!-- Include any necessary scripts -->

</html>

<!-- Add your custom styles for responsiveness -->
<style>

    @import url('https://fonts.googleapis.com/css?family=Tajawal');

   
    body {
        font-family: 'Tajawal';font-size: 22px;
    }

    /* Adjustments for small screens */
    @media (max-width: 768px) {
        .form label,
        .form input {
            font-size: 16px; /* Decrease font size for better readability */
        }
        .form-group {
            margin-bottom: 20px; /* Increase spacing between form groups */
        }
        .login-btn button {
            font-size: 18px; /* Increase button font size */
        }
    }
</style>
