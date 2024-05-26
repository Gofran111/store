<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link  rounded-circle mr-3">
      <i class="fa fa-bars" style="color: #dc3545"></i>
    </button>
    <a href="{{route('post.index')}}"  class="btn btn-outline-danger btn-sm mr-3">
   المنشورات 
  </a>
  
  
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
                  <i class="fas fa-search fa-sm"></i>lllll
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

      <!-- Nav Item - Messages -->
      {{-- <li class="nav-item dropdown no-arrow mx-1" id="messageT" data-url="{{route('messages.five')}}">
        @include('backend.message.message')
      </li> --}}

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth()->user()->name}}</span>
            <img class="img-profile rounded-circle" src="{{asset('backend/img/avatar.png')}}">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{route('admin-profile')}}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          @if(Auth()->user()->role == 'admin')
          <a class="dropdown-item" href="{{route('users.index')}}">
            <i class="fa fa-users fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
           Users
          </a>    <a class="dropdown-item" href="{{route('users.index')}}">
          
            <i class="fa fa-database fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
           backup
          </a>    <a class="dropdown-item" href="{{route('storage.link')}}">
            
            <i class="fa fa-archive fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
           storage link
          </a>
          <a class="dropdown-item" href="{{route('cache.clear')}}">
            
            <i class="fa fa-trash fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
           clear cash
          </a>
       @endif
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
