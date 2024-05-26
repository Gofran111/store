@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">اضافة فئة </h5>
    <div class="card-body">
      <form method="post" action="{{route('category.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">الاسم <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="ادخل الاسم "  value="{{old('title')}}" class="form-control">
          @error('title')
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
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

</script>


@endpush