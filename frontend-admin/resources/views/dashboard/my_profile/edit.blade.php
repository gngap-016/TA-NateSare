@extends('dashboard.layouts.main')

@section('custom-styles')
  <link rel="stylesheet" href="/dist/backend-assets/extensions/choices.js/public/assets/styles/choices.css" />
  <link rel="stylesheet" href="/dist/backend-assets/extensions/simple-datatables/style.css" />
  <link rel="stylesheet" href="/dist/backend-assets/compiled/css/table-datatable.css" />
@endsection

@section('content')

  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">Edit My Profile</h4>
        <a href="/admin/my-profile" class="col-2 btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Back to My Profile
        </a>
      </div>
    </div>
    <div class="card-body">
      <form action="/admin/my-profile/{{ $user->user_username }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
          
          <input type="hidden" name="user_level" value="{{ $user->user_level }}">
          <input type="hidden" name="user_paid_status" value="{{ $user->user_paid_status }}">
          <div class="col-md-6">
            <div class="form-group">
              <label for="user_username">Username <span class="text-danger">(Can't be empty)</span></label>
              <input type="text" name="user_username" class="form-control @error('user_username') is-invalid @enderror" id="user_username" placeholder="Username (a-z, A-Z)" value="{{ old('user_username', $user->user_username) }}" required autofocus />
              @error('user_username')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="user_name">Name <span class="text-danger">(Can't be empty)</span></label>
              <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" id="user_name" placeholder="User Name" value="{{ old('user_name', $user->user_name) }}" required />
              @error('user_name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="user_email">Email <span class="text-danger">(Can't be empty)</span></label>
              <input type="user_email" name="user_email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" placeholder="email@email.com" value="{{ old('user_email', $user->user_email) }}" required />
              @error('user_email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>

          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="user_image" class="form-label">Image Profile</label>
              <p class="text-danger">Format: JPG, JPEG | Max: 256KB</p>
              @if ($user->user_image)
                <input type="hidden" name="old_user_image" value="{{ $user->user_image }}">
                <img src="{{ env('SERVER_URL') . 'storage/' . $user->user_image }}" class="d-block img-preview img-fluid img-thumbnail mb-3 col-sm-5 mx-auto">
              @else
                <img class="d-block img-preview img-fluid img-thumbnail mb-3 col-sm-5 mx-auto">
              @endif
              <input class="form-control @error('user_image') is-invalid @enderror" type="file" id="user_image" name="user_image" accept="image/*" onchange="previewImage()" />
              @error('user_image')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>

        </div>

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
  <script src="/dist/backend-assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
  <script src="/dist/backend-assets/static/js/pages/simple-datatables.js"></script>

  <script src="/dist/backend-assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/dist/backend-assets/static/js/pages/form-element-select.js"></script>

  <script>
    document.addEventListener('trix-file-accept', function(e) {
      e.preventDefault();
    });
    
    function previewImage() {
      const image = document.querySelector('#user_image');
      const imgPreview = document.querySelector('.img-preview');

      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
      }
    }
  </script>
@endsection