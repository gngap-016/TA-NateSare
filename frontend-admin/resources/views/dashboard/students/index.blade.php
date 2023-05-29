@extends('dashboard.layouts.main')

@section('custom-styles')
  <link rel="stylesheet" href="/dist/backend-assets/extensions/simple-datatables/style.css" />
  <link rel="stylesheet" href="/dist/backend-assets/compiled/css/table-datatable.css" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" integrity="sha256-aUL5sUzmON2yonFVjFCojGULVNIOaPxlH648oUtA/ng=" crossorigin="anonymous">
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
        <h4 class="card-title col-10">All Students</h4>
        <a href="/admin/users/students/create" class="col-2 btn btn-primary">
          <i class="fa-solid fa-plus"></i> Add Student
        </a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-striped" id="table1">
        <thead>
          <tr>
            <th>No</th>
            {{-- <th>Image</th> --}}
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subscribe</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td>{{ $loop->iteration }}</td>
            {{-- <td>
              <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail" alt="{{ $post->title }}" style="max-height: 80px">
            </td> --}}
            {{-- <td>{{ $user->user_image }}</td> --}}
            <td>{{ $user->user_username }}</td>
            <td>{{ $user->user_name }}</td>
            <td>{{ $user->user_email }}</td>
            <td>{!! ($user->user_paid_status == 1) ? '<span class="badge bg-success">Subscribe</span>' : '<span class="badge bg-danger">Unsubscribe</span>' !!}</td>
            <td class="text-center">
              <a href="/admin/users/students/{{ $user->user_username }}" class="btn btn-info btn-sm">
                <i class="fa-solid fa-eye"></i>
              </a>
              <a href="/admin/users/students/edit/{{ $user->user_username }}" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pencil"></i>
              </a>
              <button class="btn btn-danger btn-sm" onclick="deleteData('{{ $user->user_username }}', '{{ $user->user_name }}')">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('custom-script')
  <script src="/dist/backend-assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
  <script src="/dist/backend-assets/static/js/pages/simple-datatables.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js" integrity="sha256-9AtIfusxXi0j4zXdSxRiZFn0g22OBdlTO4Bdsc2z/tY=" crossorigin="anonymous"></script>

  <script>
    function deleteData(parameter, name) {
      event.preventDefault();
      Swal.fire({
        title: 'Are You Sure?',
        html: " Student <b>" + name + "</b> will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#be0000',
        cancelButtonColor: '#8d8d8d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          const url = '{{ url("/admin/users/students") }}/' + parameter;
          fetch(url, {
            method: "DELETE",
            headers: {
              'X-CSRF-Token' : document.querySelector('meta[name="csrf-token"]').content
            }
          })
          .then(response => response.json())
          .then(result => {
            if(result.status == 'success') {
              Swal.fire(
                'Deleted!',
                'Student ' + name + ' has been deleted!',
                'success'
              )
              .then(result => {
                if(result.isConfirmed) {
                  location.reload();
                }
              })
            }
          })
        }
      })
    }
  </script>
@endsection