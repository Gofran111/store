
@extends('backend.layouts.ma')
@section('title','مستر سينتس')
@section('main-content')
 <!-- DataTales الرياض -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div style="background-color:  #bbad9e">
            <div class="container" id="appear" style="background-color:  #bbad9e; width:100% ; height:100%;display:none;">
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3">
                        <div class="section" style="justify-content: center; align-items: center; padding: 1.5vw; display: flex;">
                            <div id="my-qr-reader"></div>
                            <script src="https://unpkg.com/html5-qrcode"></script>
                            <script>
                               function domReady(fn) {
                                if (
                                    document.readyState === "complete" ||
                                    document.readyState === "interactive"
                                ) {
                                    setTimeout(fn, 1000);
                                } else {
                                    document.addEventListener("DOMContentLoaded", fn);
                                }
                            }

                            domReady(function () {

                                // If found you qr code
                                function onScanSuccess(decodeText, decodeResult) {
                                alert("Your QR code is: " + decodeText);
                                var table = $('#banner-dataTable').DataTable();
                                table.search(decodeText).draw();
                                $('#dtBasicExample_filter input').val(decodeText).trigger('keyup');
                            }
                                let htmlscanner = new Html5QrcodeScanner(
                                    "my-qr-reader",
                                    { fps: 10, qrbos: 250 }
                                );
                                htmlscanner.render(onScanSuccess);
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
      
         <div>
           
         </div>  <hr>
         <div class="row"> 
            <div class="col-12 col-md-6 offset-md-3">
                <a id="QR" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom"  style="width: 100%;color:white;background-color:black;"> امسح الباركود </a>
            </div> 
        </div>

         <div id='con'>
 
         <div class="row">
    <div class="col-12 col-md-6 offset-md-3">
        <a href="{{url('/outbound/cart', $order_type)}}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add" style="width: 100%;color:white;background-color:black;">المتابعة الى السلة</a>
    </div> 
</div>
         <div class="card-body">
  
           @if($products)
          <table class="table" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>*</th>
              <th>المادة</th>
              @if ($order_type == 'out')
                  <th>مخزون</th>
              @endif
              <th>الكمية</th>
              <th>اضافة</th>
            </tr>
          </thead>
          
          <tbody>
            @foreach($products as $key=>$product)
                @php
                    $photo=explode(',',$product->photo);
                    $slug = $product->slug;
                    $stock1 = DB::table('store1s')->select('stock')->where('pro_id', $product->id)->first();
                    $stock2 = DB::table('store2s')->select('stock')->where('pro_id', $product->id)->first();
                @endphp
                @foreach($photo as $data)                                                
                @endforeach  
                @if($stock1)
                 @if(Auth()->user()->region == 'store1' && $stock1->stock > 0 && $order_type == 'out')
                <tr>
                    <td><img class="rounded" src="{{asset($photo[0])}}" alt="{{$photo[0]}}" width="70"></td>
                    <td>{{$product->title}}</td>
                    <form action="{{ route('out.single-add-to-cart')}}" method="POST">
                        @csrf
                        <td><input type="hidden" name='stock' value="{{$stock1->stock}}">
                            {{$stock1->stock}}</td>
                            <input type="hidden" name="order_type" value="{{$order_type}}">
                    <td><input type="hidden" name="slug" value="{{$product->slug}}">
                        <input type="text" name="quant[1]"  id="quantity-input" class="input-number"  data-min="0" data-max="100" value="0" >
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn" style="background-color: #000000; direction: rtl; text-align: right; font-family: 'Tajawal'; font-size: 18px; border-radius: 10%;"><i class="fa fa-plus mb-1"></i></button>
                        </div>
                            </form>
                    </td>
                </tr>  
                @endif
                 @endif
                 @if($stock2)
                 @if(Auth()->user()->region == 'store2'&& $stock2->stock > 0  && $order_type == 'out')
                 <tr>
                     <td><img class="rounded" src="{{asset($photo[0])}}" alt="{{$photo[0]}}" width="70"></td>
                     <td>{{$product->title}}</td>
                     <form action="{{ route('out.single-add-to-cart')}}" method="POST">
                         @csrf
                         <td><input type="hidden" name='stock' value="{{$stock2->stock}}">
                            {{$stock2->stock}}</td>
                            <input type="hidden" name="order_type" value="{{$order_type}}">
                     <td><input type="hidden" name="slug" value="{{$product->slug}}">
                         <input type="text" name="quant[1]"  id="quantity-input" class="input-number"  data-min="0" data-max="100" value="0" >
                     </td>
                     <td>
                         <div class="d-flex align-items-center">
                             <button type="submit" class="btn" style="background-color: #000000; direction: rtl; text-align: right; font-family: 'Tajawal'; font-size: 18px; border-radius: 10%;"><i class="fa fa-plus mb-1"></i></button>
                         </div>
                             </form>
                     </td>
                 </tr>     
                 @endif
                 @endif
                 @if($order_type == 'in')
                 <tr>
                     <td><img class="rounded" src="{{asset($photo[0])}}" alt="{{$photo[0]}}" width="70"></td>
                     <td>{{$product->title}}</td>
                     <form action="{{ route('out.single-add-to-cart')}}" method="POST">
                         @csrf
                         <input type="hidden" name="order_type" value="{{$order_type}}">
                     <td><input type="hidden" name="slug" value="{{$product->slug}}">
                         <input type="text" name="quant[1]"  id="quantity-input" class="input-number"  data-min="0" data-max="100" value="0" >
                     </td>
                     <td>
                         <div class="d-flex align-items-center">
                             <button type="submit" class="btn" style="background-color: #000000; direction: rtl; text-align: right; font-family: 'Tajawal'; font-size: 18px; border-radius: 10%;"><i class="fa fa-plus mb-1"></i></button>
                         </div>
                             </form>
                     </td>
                 </tr>   
                @endif  
            @endforeach
          </tbody>
        </table>
    </div>
        @else
          <h6 class="text-center"></h6>
        @endif
      </div>
    </div>
<!-- </div> -->
<!-- </div> -->
@endsection


@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
    BODY{font-family: 'Tajawal';}
   label{color:white;}
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
      .table th,
   .table td {
    font-size: 1em; /* تحديد حجم الخط هنا */
    background-color:white;
        }
      a.active{ background-color: #bbad9e;
    border-color: #bbad9e;
        } 
       

    @media (max-width: 576px) {
       
        .table th,
    .table td {
        font-size: 0.9em; /* تحديد حجم الخط للهواتف النقالة هنا */
        padding: 0.15rem;
        text-align: center;
        vertical-align: middle; /* توسيط رأسي */

    }.th.sorting{ padding: 0.20rem;}
        
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
    


        
        i.fas.fa-eye,i.fa.fa-plus.mb-1,
        i.fas.fa-edit,
        i.fas.fa-trash-alt {
            font-size: 1rem; /* قلل حجم الخط لتقليل حجم عناصر i */
            color:white; 
            }}
            

            /* Default styles for input */
            input {
                padding: 0.5rem;
                margin: 0.5rem;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            /* Styles for small screens (up to 576px) */
            @media (max-width: 576px) {
                input {
                    width: 90%; /* Make input width 100% on small screens */
                }
                #barcode {
                word-wrap: break-word; /* Allow the content to wrap within the cell */
            }
            td{
                text-align: center;
            }

            }

        /* Styles for laptops and larger screens */
        @media (min-width: 992px) {
            input {
                width: 15%; /* Make input width 15% on laptops and larger screens */
            }
            #con{
                width: 75%;
                margin: 0 auto;
            }
        }

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
      
      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
            $("#QR").click(
                    function(){
                        $("#appear").show();
                    }
                );
                $("#close").click(
                    function(){
                        $("#appear").hide();
                    }
                );
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
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
          })
      })
  </script>
@endpush

