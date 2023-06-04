@extends('dashboard.layouts.main')

@section('custom-styles')

@endsection

@section('content')

  @if (session()->has('success'))
  <div class="alert alert-success alert-dismissible show fade">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">{{ $user->user_name }}</h4>
      </div>
    </div>
    <div class="card-body">
        <div class="row">

          <div class="col-md-8">
            <table class="table table-striped">
              <tr>
                <th style="width: 250px;">Username</th>
                <th style="width: 20px;">:</th>
                <th>{{ $user->user_username }}</th>
              </tr>
              <tr>
                <th style="width: 250px;">Name</th>
                <th style="width: 20px;">:</th>
                <td>{{ $user->user_name }}</td>
              </tr>
              <tr>
                <th style="width: 250px;">Email</th>
                <th style="width: 20px;">:</th>
                <td><a href="mailto:{{ $user->user_email }}">{{ $user->user_email }}</a></td>
              </tr>
            </table>
          </div>

          <div class="col-md-4">
            @if ($user->user_image)   
              <img src="{{ env('SERVER_URL') . 'storage/' . $user->user_image }}" class="rounded mx-auto d-block img-thumbnail" style="max-width: 250px" alt="{{ $user->user_name }}">
            @else
              <img src="/dist/assets/images/logo.png" class="rounded mx-auto d-block img-thumbnail" style="max-width: 250px" alt="{{ $user->user_name }}">
            @endif
          </div>

        </div>

        <div class="col-12 d-flex justify-content-end mt-4">
          <a href="/admin/my-profile/edit" class="btn btn-warning me-3">
            <i class="fa-solid fa-pencil"></i> Edit
          </a>
          <a href="/admin/my-profile/change-password" class="btn btn-secondary">
            <i class="fa-solid fa-unlock-keyhole"></i> Change Password
          </a>
        </div>
    </div>
  </div>
@endsection

@section('custom-script')

@endsection