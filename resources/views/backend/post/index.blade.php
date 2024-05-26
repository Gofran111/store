@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card py-3">

      <a href="{{route('post.create')}}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> اضافة منشور </a>
    </div>
 {{--  --}}
<div class="card-deck">
 
   @if(count($posts)>0)
 @foreach($posts as $post) 

  <div class="col-md-3">
    @php 
    $author_info=DB::table('users')->select('name')->where('id',$post->added_by)->get();

    @endphp
    <div class="card border-danger mb-3 " style="max-width: 22rem; ">
      <div class="card-header border-danger bg-danger text-white">{{$post->title}}</div>
      <div class="card-body text-black">
        <div class="card-title" style="font-size:90%">{{$post->quote}}</div>
        <div class="card-text">{{$post->summary}}</div>
      </div>
      <div class="card-footer bg-transparent border-danger">{{$post->author_info->name}}  
        @if (Auth()->user()->id ==$post->added_by )
         <a href="{{route('post.edit',$post->id)}}" class="btn btn-danger btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>
            
        @endif

        @if (auth()->user()->role =='admin')
        <form method="POST" action="{{route('post.destroy',[$post->id])}}">
         @csrf 
         @method('delete')
             <button class="btn btn-danger btn-sm dltBtn" data-id={{$post->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
           </form>
           @endif
      </div>
      
    </div>
  </div>
  @endforeach
  @else
      <h6 class="text-center" style="margin: 20px">No posts found!!! Please create Post</h6>
    @endif  
 
 
</div>

@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
       
      }

      .zoom:hover {
        transform: scale(5);
    
      }
      <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }.table th,
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
  a.btn.btn-danger.btn-sm.float-left 
 {
    padding: 0.25rem 0.7rem; /* البادينغ الافتراضي */
    font-size: 0.5rem; /* حجم الخط الافتراضي */
   
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
    button.btn.btn-danger.btn-sm.dltBtn,
     {
        padding: 0.1rem;  
        border-radius: 50%; 
        width: 0.7rem;  
        height: 0.7rem;  
        font-size: 0.3rem;  
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
      
      $('#product-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8,9,10]
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