<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
  />
  <!-- Google Fonts -->
  <link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
  />
  <!-- MDB -->
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css"
  rel="stylesheet"
  />

  <title>Document</title>
</head>
<body>
  
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <!-- Pills navs -->
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab"
              aria-controls="pills-login" aria-selected="true">Masuk</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab"
              aria-controls="pills-register" aria-selected="false">Daftar</a>
          </li>
        </ul>
        <!-- Pills navs -->

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('failed') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
      
        <!-- Pills content -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <form method="POST" action="{{ url('/masuk') }}">
              @csrf
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" id="username" class="form-control" name="username" />
                <label class="form-label" for="username">Username</label>
              </div>
      
              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="password" class="form-control" name="password" />
                <label class="form-label" for="password">Password</label>
              </div>
      
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">Masuk</button>
      
              <!-- Register buttons -->
              <div class="text-center">
                <p><a href="{{ url('/') }}">Kembali ke Beranda</a></p>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
            <form method="POST" action="{{ url('/register') }}">
              @csrf
              <!-- Name input -->
              <div class="form-outline mb-4">
                <input type="text" id="name" class="form-control" name="name" />
                <label class="form-label" for="name">Name</label>
              </div>
      
              <!-- Username input -->
              <div class="form-outline mb-4">
                <input type="text" id="username" class="form-control" name="username" />
                <label class="form-label" for="username">Username</label>
              </div>
      
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="email" id="email" class="form-control" name="email" />
                <label class="form-label" for="email">Email</label>
              </div>
      
              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="password" class="form-control" name="password" />
                <label class="form-label" for="password">Password</label>
              </div>
      
              <!-- Repeat Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" />
                <label class="form-label" for="password_confirmation">Ulangi password</label>
              </div>
      
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-3">Daftar</button>
            </form>
          </div>
        </div>
        <!-- Pills content -->
      </div>
    </div>
  </div>


  <!-- MDB -->
  <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"
  ></script>
</body>
</html>