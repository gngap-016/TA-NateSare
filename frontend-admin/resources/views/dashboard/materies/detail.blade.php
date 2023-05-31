@extends('dashboard.layouts.main')

@section('custom-styles')
  <link rel="stylesheet" href="/dist/backend-assets/extensions/simple-datatables/style.css" />
  <link rel="stylesheet" href="/dist/backend-assets/compiled/css/table-datatable.css" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" integrity="sha256-aUL5sUzmON2yonFVjFCojGULVNIOaPxlH648oUtA/ng=" crossorigin="anonymous">
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <div>
          <a href="/admin/my-materies" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Materies
          </a>
        </div>
        <div>
          <a href="/admin/materies/edit/{{ $matery->post_slug }}" class="btn btn-warning me-2">
            <i class="fa-solid fa-pencil"></i> Edit
          </a>
          <button class="btn btn-danger" onclick="deleteData('{{ $matery->post_slug }}', '{{ $matery->post_title }}')">
            <i class="fa-solid fa-trash"></i> Delete
          </button>
        </div>
      </div>
      <div class="text-center">
        <hr>
        <h4 class="card-title mt-3">{{ $matery->post_title }}</h4>
        @if ($matery->post_publish === 1)
          <span class="badge bg-success">Published</span>
        @else
          <span class="badge bg-secondary">Draft</span>
        @endif
      </div>
    </div>
    <div class="card-body">
      @if ($matery->post_image)
        <img src="{{ env('SERVER_URL') . 'storage/' . $matery->post_image }}" class="rounded mx-auto d-block img-thumbnail" style="max-height: 200px" alt="{{ $matery->post_title }}">
      @else
        <img src="/dist/assets/images/logo.png" class="rounded mx-auto d-block img-thumbnail" style="max-height: 200px" alt="{{ $matery->post_title }}">
      @endif
      <p class="text-center mt-3">{{ $matery->post_author }} | {{ $matery->post_category }} | {{ ($matery->post_publish === 1) ? $matery->post_published_at : 'Not Yet Published' }}</p>

      <div class="text-dark">
        {!! $matery->post_content !!}
      </div>

      <div class="divider">
        <div class="divider-text">Comments</div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-lg">
          {{-- <thead>
            <tr>
              <th>Name</th>
              <th>Comment</th>
            </tr>
          </thead> --}}
          <tbody>
            @foreach ($matery->post_comments as $comment)
              <tr>
                <td class="col-3">
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-md">
                      <img src="{{ env('SERVER_URL') . 'storage/' . $comment->user->image }}" />
                    </div>
                    <p class="font-bold ms-3 mb-0">{{ $comment->user->name }}</p>
                  </div>
                </td>
                <td class="col-auto">
                  <span class="text-secondary" style="font-size: 14px">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                  <p class="mb-0">
                    {!! $comment->body !!}
                  </p>
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
        html: " Matery <b>" + name + "</b> will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#be0000',
        cancelButtonColor: '#8d8d8d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          const url = '{{ url("/admin/materies") }}/' + parameter;
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
                'Matery ' + name + ' has been deleted!',
                'success'
              )
              .then(result => {
                if(result.isConfirmed) {
                  location.href = '{{ url("admin/materies") }}';
                }
              })
            }
          })
        }
      })
    }
  </script>
@endsection