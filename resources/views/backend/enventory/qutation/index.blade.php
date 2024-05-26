@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
    {{-- <a href="{{route('export_Inbound')}}" class="btn btn-danger btn-sm float-right export-btn" style="margin-left: 0%;" data-toggle="tooltip" data-placement="bottom" ><i class="fas fa-export"></i> تصدير</a> --}}

      <h6 class="m-0 font-weight-bold text-danger float-left">عروض الاسعار </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive" style="overflow-x: auto;">
        @if(count($orders)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>رقم العرض  </th>
              <th>المندوب</th>
              <th>الزبون </th>
              <th>statuse </th>
              <th>edit</th>
              <th>show</th>
              <th>delete</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>رقم العرض  </th>
              <th>المندوب</th>
              
              <th>الزبون </th>
              <th>statuse </th>
              <th>edit</th>
              <th>show</th>
              <th>delete</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>{{$order->id}}</td>
              <td>{{$order->customer}}</td> 
               @php
        $user = DB::table('users')->where('id', $order->user_id)->first();        
@endphp <th>{{$user->name}}</th>
              <td>
                  @if($order->status=='active')
                      <span class="badge badge-success">{{$order->status}}</span>
                  @else
                      <span class="badge badge-warning">{{$order->status}}</span>
                  @endif
              </td>
                    <td>
                      <a href="{{route('qutation.show',$order->id)}}" class="btn btn-danger btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        </td>
                         <td>  <a href="{{route('qutation.edit',$order->id)}}" class="btn btn-danger btn-sm" style="border-radius: 50%;" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fas fa-edit"></i></a> 
                        </td>
                         <td>
                      @if (Auth()->user()->role == 'admin')
                      <form method="POST" action="{{route('qutation.destroy',[$order->id])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id="{{$order->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                      @endif
                    </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        @else
          <h6 class="text-center">لا يوجد عروض  لحد الأن</h6>
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
     
      
      /* تحديد حجم الخط للعناصر داخل الجدول */
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
    }  a.btn.btn-danger.btn-sm.export-btn {
    padding: 0.25rem 0.7rem; /* البادينغ الافتراضي */
    font-size: 0.5rem; /* حجم الخط الافتراضي */
    border-radius: 10%; /* جعل العناصر دائرية */
  height: 1rem;
  width: 3rem;
  text-align: center;}
  .img-fluid{
      height:0.5rem;
      width: 0.5rem;
    }
  
    h6 {
        font-size: 0.8rem; /* تحديد حجم الخط لعناوين h6 في الهواتف النقالة */
    }

    /* تحديد الحجم والشكل لعناصر a وزر الحذف بشكل منفصل */
    a.btn.btn-danger.btn-sm,
    button.btn.btn-danger.btn-sm.dltBtn {
        padding: 0.1rem; /* قلل البادينغ لتقليل حجم العناصر */
        border-radius: 50%; /* جعل العناصر دائرية */
        width: 0.7rem; /* تحديد عرض العناصر */
        height: 0.7rem; /* تحديد ارتفاع العناصر */
        font-size: 0.3rem; /* قلل حجم الخط لتقليل حجم العناصر */
    }


    
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
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5] // 5 is the index of the last column
                }
            ]
        } );

      $(document).ready(function(){
        $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
            var dataID=$(this).data('id');
            e.preventDefault();
            swal({
                title: "هل انت متأكد?",
                text: "لن  يستطيع أحد استخدام عرض السعر هذا!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                } else {
                    swal("بيانات في امان!");
                }
            });
        })
      });
  </script>
@endpush
