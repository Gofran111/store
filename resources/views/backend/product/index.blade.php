@extends('backend.layouts.master')

@section('main-content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link"  href="{{route('allproduct')}}">الجرد العام  </a>
      </li>
      @if (Auth()->user()->region == 'store1' ||Auth()->user()->role == 'admin')
      <li class="nav-item ">
        <a class="nav-link"  href="{{route('stores', 'store1s')}}">الرياض  </a>
      </li>
      @endif
      @if (Auth()->user()->region == 'store2' ||  Auth()->user()->role == 'admin' )
      <li class="nav-item">
        <a class="nav-link"href="{{route('stores', 'store2s')}}">الغربية </a>
      </li>
      @endif
      @if (Auth()->user()->role == 'user' ||Auth()->user()->role == 'admin' )
      <li class="nav-item">
        <a class="nav-link" href="{{route('stores', 'store4s')}}">العليا</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="{{route('stores', 'store3s')}}">سرداب </a>
      </li>
     @endif
     
    </ul>
  </div>
</nav>
<script>// Get the current URL
  var currentUrl = window.location.href;
  
  // Get all the anchor elements inside the navbar
  var navLinks = document.querySelectorAll('.navbar-nav .nav-link');
  
  // Loop through each anchor element
  navLinks.forEach(function(navLink) {
    // Check if the href attribute of the anchor element matches the current URL
    if (navLink.href === currentUrl) {
      // Add the 'active' class to the parent 'li' element
      navLink.parentNode.classList.add('active');
    }
  });
  </script>
  
{{-- //////////////////////////////////////////////// --}}
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-danger float-left">جرد مواد </h6>
      <a href="{{route('export_stock',$store)}}" class="btn btn-danger btn-sm float-right export-btn" style="margin-left: 1%;" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-export"></i> تصدير</a>
    </div><script>// Get the current URL
      var currentUrl = window.location.href;
      
      // Get the element where you want to change the text
      var headerElement = document.querySelector('.card-header h6');
      
      // Define a mapping of URLs to titles
      var titles = {
        '{{route('allproduct')}}': 'الجرد العام',
        '{{route('stores', 'store1s')}}': 'الرياض',
        '{{route('stores', 'store2s')}}': 'الغربية',
        '{{route('stores', 'store4s')}}': 'العليا',
        '{{route('stores', 'store3s')}}': 'سرداب'
      };
      
      // Loop through the mapping and update the title if the current URL matches
      Object.keys(titles).forEach(function(url) {
        if (currentUrl.includes(url)) {
          headerElement.textContent = titles[url];
        }
      });
        </script>

    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>رقم المادة </th>
              <th>اسم المادة </th>
              <th>الفئة </th>
              <th>المخزون </th>
              <th>الصورة </th>
              <th>*</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>رقم المادة </th>
              <th>اسم المادة </th>
              <th>الفئة </th>
              <th>المخزون </th>
              <th>الصورة </th>
              <th>*</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($products as $product)
              @php
              $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
                $stock =0;
                if ($store === 'store1s') {
                    $stock = DB::table('store1s')->select('stock')->where('pro_id', $product->id)->first();
                } 
                if ($store === 'store2s') {
                    $stock = DB::table('store2s')->select('stock')->where('pro_id', $product->id)->first();
                } 
                if ($store === 'store3s') {
                    $stock = DB::table('store3s')->select('stock')->where('pro_id', $product->id)->first();
                } 
                if ($store === 'store4s') {
                    $stock = DB::table('store4s')->select('stock')->where('pro_id', $product->id)->first();
                } 
       
            @endphp
                          
                @if($stock)
              @if((Auth()->user()->role == 'admin' || $product->status == 'active')&& $stock->stock > 0)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->title}}</td>
                    <td>{{$product->cat_info['title']}}</td>
                    <td><span class="badge badge-danger">{{ $stock->stock }}</td>
                    <td>
                        @if($product->photo)
                            <img src="{{asset($product->photo)}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->photo}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        @endif
                    </td>
                    <td> @if($product->status=='active')
                <span class="badge badge-success">{{$product->status}}</span>
            @else
                <span class="badge badge-warning">{{$product->status}}</span>
            @endif</td>
                </tr>
              @endif
              @endif

            @endforeach
          </tbody>
        </table>
        <!-- <nav aria-label="Page navigation">
  <ul class="pagination pagination-sm">
    <!- تعديلات أو إضافات العناصر هنا --
  </ul>
</nav> -->

       
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
    
   
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
      .table th,
   .table td {
    font-size: 0.7em; /* تحديد حجم الخط هنا */
}




@media (max-width: 576px) {
    .table th,
    .table td {
        font-size: 0.3em; /* تحديد حجم الخط للهواتف النقالة هنا */
        padding: 0.15rem;
        text-align: center;
    } 
    
    span.badge.badge-danger.1{  
        padding: 0.25rem 0.5rem; /* البادينغ الافتراضي */
    font-size: 0.3rem; /* حجم الخط الافتراضي */
    border-radius: 10%; /* جعل العناصر دائرية */
  height: 1rem;
  width: 1rem;
  text-align: center;}
    h6 {
        font-size: 0.8rem; /* تحديد حجم الخط لعناوين h6 في الهواتف النقالة */
    }
    .img-fluid{
      height:0.5rem;
      width: 0.5rem;
    }

    /* تحديد الحجم والشكل لعناصر a وزر الحذف بشكل منفصل */
  


    
    i.fas.fa-eye,
    i.fas.fa-edit,
    i.fas.fa-trash-alt {
        font-size: 0.3rem; /* قلل حجم الخط لتقليل حجم عناصر i */
    
}}
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

$(document).ready(function() {
        $('#product-dataTable').DataTable({
            "scrollX": false,
            "paging": true, // Enable pagination
            "pageLength": 15, // Set the number of rows per page
            // Column definitions...
        });
    });

      // Sweet alert

      $(document).ready(function(){
        $('.dltBtn').click(function(e){
          var form=$(this).closest('form');
          var dataID=$(this).data('id');
          e.preventDefault();
          swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                   form.submit();
                } else {
                    swal("Your data is safe!");
                }
            });
        });
      });
  </script>
@endpush
