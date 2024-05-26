@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">اضافة مادة </h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">اسم المادة  <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="ادخل الاسم "  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>



        <div class="form-group">
          <label for="cat_id">الفئة  <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">اختر الفئة </option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
          </select>
          @error('cat_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="barcode" class="col-form-label">باركود الامين </label>
          <input id="barcode" type="number" name="barcode" placeholder="رمز الباركود  "  value="{{old('barcode')}}" class="form-control">
          @error('barcode')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="price" class="col-form-label">السعر</label>
          <input id="price" type="number" name="price" placeholder="0"  value="{{old('price')}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="minprice" class="col-form-label">السعر الادنى</label>
          <input id="minprice" type="number" name="minprice" placeholder="السعر الأدنى"value="{{old('minprice')}}"  class="form-control">
          @error('minprice')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="maxprice" class="col-form-label">السعر الأعلى</label>
          <input id="maxprice" type="number" name="maxprice" placeholder="السعر الأعلى"value="{{old('maxprice')}}"  class="form-control">
          @error('maxprice')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
  

        <div class="form-group" id='descript'>
          <label for="descript">الوصف<span class="text-danger">*</span></label>
          <input id="descript" type="text" name="description" placeholder="الوصف  " value="{{old('description')}}"  class="form-control">
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

   
        
   
      
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">الصورة  <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
              </span>
          <input  class="form-control" type="file" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">الحالة  <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-danger">اعادة انشاء</button>
           <button class="btn btn-danger" type="submit">حفظ</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>


    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush