 <header class="header shop">
    <!-- Topbar -->
    <div class="topbar" >
        <div class="container">
            <div class="row">
              
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="left-content"style="font-family:'Tajawal';font-size: 20px;">
                        <ul class="list-main"style="font-family:'Tajawal';font-size: 20px;">
                            <style>
                                @import url('https://fonts.googleapis.com/css?family=Tajawal');
                            
                            span{font-family: 'Tajawal';font-size: 12px;"}	
                            .li {
                            font-family: 'Tajawal';font-size: 20px;
                            }
                            
                            body {
                            font-family: 'Tajawal';font-size: 20px;
                            }
                            </style>
                            @auth 
                                {{-- @if(Auth::user()->role=='admin') --}}
                                    <li style="font-family:'Tajawal';font-size: 20px;"><i class="ti-user"></i> <a href="{{route('admin')}}"   style="font-family:'Tajawal';font-size: 22px; direction: rtl ;text-align: right;">لوحة التحكم </a></li>
                     
                                {{-- <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li> --}}

                            
                                {{-- <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li> --}}
                            @endauth
                        </ul>
                    </div>
                    

                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->

    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header> 
<!-- End Shop Newsletter -->
<style>
    @import url('https://fonts.googleapis.com/css?family=Tajawal');

span{font-family: 'Tajawal';font-size: 12px;"}	
.li {
font-family: 'Tajawal';font-size: 20px;
}

body {
font-family: 'Tajawal';font-size: 20px;
}
</style>