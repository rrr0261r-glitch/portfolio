@extends('layouts.app')

@section('title','Create Post')

@section('content')
  <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(up to 3)</span>
        </label>

        @foreach($all_categories as $category)
            <div class="form-check form-check-inline">
               <input type="checkbox" name="category[]" id="{{ $category->name}}" value="{{$category->id}}" class="form-check-input">
               <label class="form-check-label" for="{{ $category->name}}">
                   {{ $category->name }}
               </label>
            </div>
            <!-- error -->
         @error('category')
            <div class="text-danger small">{{$message}}</div>
         @enderror
        @endforeach
    </div>
    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="what's on your mind?">
            {{ old('description') }}
        </textarea>
        <!-- Error -->
         @error('description')
            <div class="text-danger small">{{$message}}</div>
         @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
            <div id="image-info" class="form-text">
               The acceptable formats are jpeg, png, jpg, and gif only <br>
            </div>
            <!-- Error -->
              @error('image')
                <div class="text-danger small">{{$message}}</div>
              @enderror
    </div>
    <button type="submit" class="btn btn-primary px-5">Post</button>
  </form>

@endsection