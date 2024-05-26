@extends('backend.layouts.master')

@section('main-content')
<div class="container">

  <div class="card">
      <h5 class="card-header">{{$post->added_by}}</h5>
      <div class="card-body">
        <form method="post" action="{{route('post.update',$post->id)}}">
          @csrf 
          @method('PATCH')
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">العنوان <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$post->title}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
          <div class="form-group">
            <label for="quote" class="col-form-label">عنوان فرعي </label>
            <textarea class="form-control" id="quote" name="quote">{{$post->quote}}</textarea>
            @error('quote')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
          <div class="form-group">
            <label for="summary" class="col-form-label">المنشور  <span class="text-danger">*</span></label>
            <textarea class="form-control" id="summary" name="summary">{{$post->summary}}</textarea>
            @error('summary')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
         <input type='hidden' name='added_by' value='{{Auth()->user()->id}}'></input>
    
  
          </div>
<button style="background-color:#dc3534;color:white; border-color:white;">تحديث </button>
        </form>
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

@endpush