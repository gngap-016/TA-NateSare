@extends('dashboard.layouts.main')

@section('custom-styles')
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <h4 class="card-title col-10">Add Category for Materies</h4>
        <a href="/admin/categories" class="col-2 btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i> Back to Categories
        </a>
      </div>
    </div>
    <div class="card-body">
      <form action="/admin/categories" method="POST">
        @csrf
        <div class="form-group">
          <label for="category_name">Category Name</label>
          <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" id="category_name" placeholder="Nama kategori" value="{{ old('category_name') }}" required autofocus />
          @error('category_name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        </div>
        <div class="form-group">
          <label for="category_slug">Category Slug</label>
          <input type="text" name="category_slug" class="form-control @error('category_slug') is-invalid @enderror" id="category_slug" value="{{ old('category_slug') }}" readonly required />
          @error('category_slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
        </div>

        <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary mb-1">
            Add Category
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('custom-script')
  <script>
    const name = document.querySelector('#category_name');
    const slug = document.querySelector('#category_slug');

    name.addEventListener('change', function() {
      fetch('/admin/categories/check-slug?category_name=' + name.value)
        .then(response => response.json())
        .then(data => slug.value = data.category_slug);
    });
  </script>
@endsection