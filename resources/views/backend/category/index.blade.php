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
      <h6 class="m-0 font-weight-bold text-danger float-left">قائمة الفئات </h6>
      <a href="{{route('category.create')}}" class="btn btn-danger btn-sm float-right export-btn " data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> اضافة فئة </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($categories)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>الرقم التسلسلي </th>
              <th>الاسم </th>
              <th>*</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>الرقم التسلسلي </th>
              <th>الاسم </th>
              <th>*</th>
            </tr>
          </tfoot>
          <tbody>

            @foreach($categories as $category)
              @php
              @endphp
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}</td>
                    <td>
                        <a href="{{route('category.edit',$category->id)}}" class="btn btn-danger btn-sm float-left mr-1"  data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('category.destroy',[$category->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$category->id}}  data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$categories->links()}}</span>
        @else
          <h6 class="text-center">No Categories found!!! Please create Category</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
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

      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
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
@endpush
