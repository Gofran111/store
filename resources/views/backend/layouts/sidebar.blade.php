<style>
  .navbar-nav.bg-gradient-primary {
      background: linear-gradient(to right, #bbad9e, #bbad9e);
  }
</style>
{{-- navbar --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">{{Auth()->user()->role}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>لوحة التحكم </span></a>
    </li>
    <!-- // transfer -->
    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (Auth()->user()->role == 'user' ||Auth()->user()->role == 'admin' )
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="true" data-target="#inbound" aria-controls="inbound">
            <i class="fas fa-arrow-circle-down"></i>
            <span> ادخالات المستودع  </span>
          </a>
          <div id="inbound" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">ادخال  </h6>
              <a class="collapse-item" href="{{route('in.order.index')}}">عرض</a>
              <a class="collapse-item" href="{{route('inbound')}}">اضافة </a>
            </div>
          </div>
        </li>
        @endif
        
        <!-- //price orders -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="true" data-target="#qutation" aria-controls="qutation">
            <i class="fas fa-refresh fa-chart-area"></i>
            <span>عروض الاسعار  </span>
          </a>
          <div id="qutation" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">عرض سعر</h6>
              @if(Auth()->user()->role == 'admin')
              <a class="collapse-item" href="{{route('qutation.index')}}">عرض</a>
              @else
              <a class="collapse-item" href="{{route('envoy.qutation.index')}}">عرض</a>
              @endif 
              <a class="collapse-item" href="{{route('qutation')}}">اضافة </a>
            </div>
          </div>
        </li>
        <!-- //envoy movements -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="true" href="javascript:void(0);" data-target="#Envoy" aria-controls="Envoy" >
              <i class="fas fa-arrow-circle-up"></i>
              <span>حركات المندوبين </span>
            </a>
            <div id="Envoy" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">الحركات </h6>
                @if(Auth()->user()->role == 'user')
                <a class="collapse-item" href="{{route('out.order.index')}}">ترحيل الطلبيات </a>
                @else
                <a class="collapse-item" href="{{route('env.order.index')}}">عرض  </a>
                @endif
                <a class="collapse-item" href="{{route('outbound', 'out')}}">طلبية </a>
                <a class="collapse-item" href="{{route('outbound', 'in')}}">مرتجع </a>
              </div>
            </div>
          </li>

    
        <!-- submit envoy order -->
 
      
      @if (Auth()->user()->role == 'admin')
    <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            بطاقات 
        </div>
            </li> <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="true" data-target="#itemCollapse"  aria-controls="itemCollapse">
            <i class="fa fa-folder-open"></i>
            <span>بطاقات  </span>
          </a>
          <div id="itemCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">تعريف و تعديل   </h6>
              <a class="collapse-item" href="{{route('indeedit')}}"> مواد   </a>
              <a class="collapse-item" href="{{route('category.index')}}"> الفئات </a>
                <a class="collapse-item" href="{{route('shipping.index')}}"> الشحن </a>
              </div>
          </div>
      </li>
    
        @endif
    <!-- Divider -->

        <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                المستودعات 
            </div>
             <li class="nav-item">
            <a class="nav-link" href="{{route('allproduct')}}">
                <i class="fas fa fa-th-large"></i>
                <span>جرد مواد المستودعات </span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

</ul>
<style>
  @import url('https://fonts.googleapis.com/css?family=Tajawal');

  

body {
  font-family: 'Tajawal';font-size: 22px;
}
span{ font-family: 'Tajawal';font-size: 22px;}
li{ font-family: 'Tajawal';font-size: 22px;}
ul{ font-family: 'Tajawal';font-size: 22px;}

</style>
