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

  @if (session()->has('failed'))
  <div class="alert alert-danger alert-dismissible show fade">
    <i class="bi bi-check-circle"></i> {{ session('failed') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">{{ $title }}</h4>
        <a href="/admin/categories/create" class="col-2 btn btn-primary">
          <i class="fa-solid fa-plus"></i> Add Category
        </a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-striped" id="table1">
        <thead>
          <tr>
            <th>No</th>
            <th>Slug</th>
            <th>Name</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->category_slug }}</td>
            <td>{{ $category->category_name }}</td>
            <td class="text-center">
              {{-- <a href="/admin/categories/{{ $category->category_slug }}" class="btn btn-info btn-sm">
                <i class="fa-solid fa-eye"></i>
              </a> --}}
              <a href="/admin/categories/edit/{{ $category->category_slug }}" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pencil"></i>
              </a>
              <button class="btn btn-danger btn-sm" onclick="deleteData('{{ $category->category_slug }}', '{{ $category->category_name }}')">
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
        html: " Category <b>" + name + "</b> will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#be0000',
        cancelButtonColor: '#8d8d8d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          const url = '{{ url("/admin/categories") }}/' + parameter;
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
                'Category ' + name + ' has been deleted!',
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