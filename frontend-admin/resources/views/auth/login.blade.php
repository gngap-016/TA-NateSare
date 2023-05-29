<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | NateSare</title>

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

    <style>
      .divider:after,
      .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
      }
      .h-custom {
        height: calc(100% - 73px);
      }
      @media (max-width: 450px) {
        .h-custom {
          height: 100%;
        }
      }
    </style>
  </head>
  <body>
    <section class="vh-100">
      <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
              class="img-fluid" alt="Sample image">
          </div>
          <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            @if (session()->has('success'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <form action="/login" method="POST">
              @csrf
              <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                <p class="lead fw-normal mb-3 mx-auto">Log In</p>
                {{-- <button type="button" class="btn btn-primary btn-floating mx-1">
                  <i class="fab fa-facebook-f"></i>
                </button>
    
                <button type="button" class="btn btn-primary btn-floating mx-1">
                  <i class="fab fa-twitter"></i>
                </button>
    
                <button type="button" class="btn btn-primary btn-floating mx-1">
                  <i class="fab fa-linkedin-in"></i>
                </button> --}}
              </div>
    
              {{-- <div class="divider d-flex align-items-center my-4">
                <p class="text-center fw-bold mx-3 mb-0">Or</p>
              </div> --}}
    
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" name="username" id="username" class="form-control form-control-lg"
                  placeholder="Enter a valid username" />
                <label class="form-label" for="username">Username</label>
              </div>
    
              <!-- Password input -->
              <div class="form-outline mb-3">
                <input type="password" name="password" id="password" class="form-control form-control-lg"
                  placeholder="Enter password" />
                <label class="form-label" for="password">Password</label>
              </div>
    
              {{-- <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                  <label class="form-check-label" for="form2Example3">
                    Remember me
                  </label>
                </div>
                <a href="#!" class="text-body">Forgot password?</a>
              </div> --}}
    
              <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" class="btn btn-primary btn-lg"
                  style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                {{-- <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!"
                    class="link-danger">Register</a></p> --}}
              </div>
    
            </form>
          </div>
        </div>
      </div>
      <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
          Copyright &copy; {{ date('Y') }} NateSare. All rights reserved.
        </div>
        <!-- Copyright -->
    
        <!-- Right -->
        <div>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-google"></i>
          </a>
          <a href="#!" class="text-white">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
        <!-- Right -->
      </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js" integrity="sha512-DXEKT9U5aI4s0iPRILUN6itJ0BkIdMYmJg+nnirpdAklNOz972QQhjvdHYnDCn+5W/HBvAiXYG2UaHEHH87gpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>