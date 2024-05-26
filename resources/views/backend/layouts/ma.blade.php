<!DOCTYPE html>
<html lang="en">

@include('backend.layouts.head')

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        @auth 
        <i class="ti-user"></i> <a href="{{route('admin')}}"  style="font-family: 'Tajawal'; font-size: 18px; COLOR:BLACK">لوحة التحكم</a>
    @endauth
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
      
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
             
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-danger" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
      
      
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
             @include('backend.notification.show')
            </li> 
 
            <div class="topbar-divider d-none d-sm-block"></div>
      
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth()->user()->name}}</span>

                  <img class="img-profile rounded-circle" src="{{asset('backend/img/avatar.png')}}">
                {{-- @endif --}}
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('admin-profile')}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('user.logout') }}"
                      onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                       <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ __('Logout') }}
                  </a>
      
                  <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </div>
            </li>
      
          </ul>
      
        </nav>
      
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        @yield('main-content')
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      @include('backend.layouts.footer')

</body>

</html>
