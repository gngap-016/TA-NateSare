@extends('dashboard.layouts.main')

@section('custom-styles')

@endsection

@section('content')

  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">Change Password: {{ $user->user_name }}</h4>
        <a href="/admin/my-profile" class="col-2 btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Back to My Profile
        </a>
      </div>
    </div>
    <div class="card-body">
      <form action="/admin/my-profile/change-password/{{ $user->user_username }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row">
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="user_password">Change Password <span class="text-danger">(Can't be empty)</span></label>
              <input type="password" name="user_password" class="form-control @error('user_password') is-invalid @enderror" id="user_password" placeholder="New Password" required />
              @error('user_password')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="user_password_confirmation">Confirm New Password <span class="text-danger">(Can't be empty)</span></label>
              <input type="password" name="user_password_confirmation" class="form-control @error('user_password') is-invalid @enderror" id="user_password_confirmation" placeholder="Confirm New Password" required />
              @error('user_password')
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

@endsection