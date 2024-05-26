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
      <a href="{{route('export_outbound')}}" class="btn btn-danger btn-sm float-right" style="margin-left: 1%;" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-export"></i> تصدير</a>
      <h6 class="m-0 font-weight-bold text-danger float-left">قائمة الطلبيات  </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th> الرقم</th>
              <th>تاريخ الاخراج</th>
              <th>رقم ايصال الاخراج</th>
              <th>نوع الاخراج  </th>
              <th>المندوب  المستلم</th>
              <th>حالة الطلب</th>
              <th>تم الاستلام</th>
              <th>أكثر</th>
              @if (Auth()->user()->role == 'admin')
              <th>حذف</th>
              @endif
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th> الرقم</th>
              <th>تاريخ الاخراج</th>
              <th>رقم ايصال الاخراج</th>
              <th>نوع الاخراج</th>
              <th>المندوب  المستلم</th>
              <th>حالة الطلب</th>
              <th>تم الاستلام</th>
              <th>أكثر</th>
              @if (Auth()->user()->role == 'admin')
              <th>حذف</th>
              @endif
              </tr>
          </tfoot>
          <tbody>

            @foreach($orders as $order) 
      
                @if (Auth()->user()->id == $order->user_id ||Auth()->user()->role == 'user' || Auth()->user()->role == 'admin')
                  <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->rec_num}}</td>
                    <td>{{$order->order_name}}</td>
                    <td>{{$order->env_name}}</td>
                    <td>
                        @if($order->status=='process')
                          <span class="badge badge-warning">{{$order->status}}</span>
                        @else
                          <span class="badge badge-danger">{{$order->status}}</span>
                        @endif
                    </td>
                      <form action="{{route('checkbox',[$order->id])}}">
                        @if ($order->ok == 1)
                        <td class='checkbox-container'><input type="checkbox" name="ok" id="ok" checked disabled > </td>
                        @else
                        <td class='checkbox-container'><input type="checkbox" name="ok" id="ok" onchange="this.form.submit()" value="1"> </td>
                        @endif
                        </form>
                    <td>
                        <a href="{{route('out.order.show',$order->id)}}" class="btn btn-danger btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                    </td>
                   
                      @if (Auth()->user()->role == 'admin'&& $order->status == 'process')
                      <td>
                        <form method="POST" action="{{route('env.order.destroy',[$order->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form> 
                      </td>
                      @elseif (Auth()->user()->role == 'admin'&& $order->status=='done')
                      <td>
                        <form method="POST" action="{{route('out.order.destroy',[$order->id])}}">
                          @csrf 
                          @method('delete')
                             <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      </td>
                      @endif  
                    </tr>   
                @endif
            @endforeach

          </tbody>
        </table>
        @else
          <h6 class="text-center">لا يوجد طلبيات لحد الأن</h6>
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
  text-align: center;
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
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
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
  <style>
    #ok {
        transform: scale(2); /* Make the checkbox bigger */
    }
    .checkbox-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .checkbox-container input[type="checkbox"] {
        transform: scale(2); /* Make the checkbox bigger */
    }
</style>
@endpush