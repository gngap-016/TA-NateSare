@extends('dashboard.layouts.main')

@section('custom-styles')
  <link rel="stylesheet" href="/dist/backend-assets/extensions/summernote/summernote-lite.css" />

  <link rel="stylesheet" href="/dist/backend-assets/compiled/css/form-editor-summernote.css" />
@endsection

@section('content')
  @if($errors->any())
    <h4>{{$errors->first()}}</h4>
  @endif

  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">Edit Matery</h4>
        <a href="/admin/materies" class="col-2 btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Back to Materies
        </a>
      </div>
    </div>
    <div class="card-body">
      <form action="/admin/materies/{{ $matery->post_slug }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="post_title">Matery Title</label>
          <input type="text" name="post_title" class="form-control @error('post_title') is-invalid @enderror" id="post_title" placeholder="Matery Title" value="{{ old('post_title', $matery->post_title) }}" required autofocus />
          @error('post_title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        </div>

        <div class="form-group">
          <label for="post_slug">Matery Slug</label>
          <input type="text" name="post_slug" class="form-control @error('post_slug') is-invalid @enderror" id="post_slug" placeholder="Matery Slug" value="{{ old('post_slug', $matery->post_slug) }}" required />
          @error('post_slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        </div>

        <fieldset class="form-group">
          <label for="post_category">Category</label>
          <select class="form-select" name="post_category">
            @foreach ($categories as $category)
              @if (old('post_category', $matery->post_category) == $category->category_id)
                <option value="{{ $category->category_id }}" selected>{{ $category->category_name }}</option>
              @else
                <option value="{{ $category->category_id}}">{{ $category->category_name }}</option>
              @endif
            @endforeach
          </select>
        </fieldset>

        <div class="form-group">
          <label for="post_image" class="form-label">Matery Cover</label>
          <p class="text-danger">Format: JPG,JPEG, PNG | Maksimal: 512KB</p>
          <input type="hidden" name="old_post_image" value="{{ $matery->post_image }}">
          @if ($matery->post_image)
            <img src="{{ env('SERVER_URL') . 'storage/' . $matery->post_image }}" class="d-block img-preview img-fluid img-thumbnail mb-3 col-sm-5 mx-auto">
          @else
            <img class="d-block img-preview img-fluid img-thumbnail mb-3 col-sm-5 mx-auto">
          @endif
          <input class="form-control @error('post_image') is-invalid @enderror" type="file" id="post_image" name="post_image" onchange="previewImage()" />
          @error('post_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label for="summernote" class="form-label">Matery Body</label>
          @error('post_content')
            <p class="text-danger">{{ $message }}</p>
          @enderror
          <textarea name="post_content" id="summernote">{{ old('post_content', $matery->post_content) }}</textarea>
        </div>

        <fieldset class="form-group">
          <label for="post_status">Status</label>
          <select class="form-select" name="post_status">
            <option value="free" {{ old('post_status', $matery->post_status) == "free" ? 'selected' : '' }}>Free</option>
            <option value="paid" {{ old('post_status', $matery->post_status) == "paid" ? 'selected' : '' }}>Paid</option>
          </select>
        </fieldset>

        <fieldset class="form-group">
          <label for="post_publish">Publish</label>
          <input type="hidden" name="old_post_publish" value="{{ $matery->post_publish }}">
          <select class="form-select" name="post_publish">
            <option value="0" {{ old('post_publish', $matery->post_publish) == 0 ? 'selected' : '' }}>Drafted</option>
            <option value="1" {{ old('post_publish', $matery->post_publish) == 1 ? 'selected' : '' }}>Published</option>
          </select>
        </fieldset>

        <div class="col-12 d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary mb-1">
            Save Change
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('custom-script')
  <script src="/dist/backend-assets/extensions/jquery/jquery.min.js"></script>
  <script src="/dist/backend-assets/extensions/summernote/summernote-lite.min.js"></script>
  <script src="/dist/backend-assets/static/js/pages/summernote.js"></script>
  
  <script>
    const title = document.querySelector('#post_title');
    const slug = document.querySelector('#post_slug');

    title.addEventListener('change', function() {
      fetch('/admin/materies/check-slug?post_title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.post_slug);
    });

    document.addEventListener('trix-file-accept', function(e) {
      e.preventDefault();
    });

    function previewImage() {
      const image = document.querySelector('#post_image');
      const imgPreview = document.querySelector('.img-preview');

      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
      }
    }
  </script>
@endsection