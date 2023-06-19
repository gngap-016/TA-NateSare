<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="dist/assets/img/logo.png" alt="">
        <span>NateSare</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto {{ (!Request::is('materi*') ? 'active' : '') }}" href="{{ (Request::is('materi*')) ? '/' : '#hero' }}">Beranda</a></li>
          <li><a class="nav-link scrollto" href="{{ (Request::is('materi*')) ? '/' : '#about' }}">Tentang</a></li>
          <li><a class="nav-link scrollto" href="{{ (Request::is('materi*')) ? '/' : '#services' }}">Layanan</a></li>
          {{-- <li><a class="{{ (Request::is('materi*') ? 'active' : '') }}" href="{{ url('/materi') }}">Materi</a></li> --}}
          <li class="dropdown">
            <a href="#" class="{{ (Request::is('materi*') ? 'active' : '') }}">
              <span>Materi</span> <i class="bi bi-chevron-down"></i>
            </a>
            <ul>
              <li><a href="{{ url('/materi/gratis') }}" class="{{ (Request::is('materi/gratis*') ? 'active' : '') }}">Gratis</a></li>
              @if (isset($_COOKIE['my_key']))  
                <li><a href="{{ url('/materi/berbayar') }}" class="{{ (Request::is('materi/berbayar*') ? 'active' : '') }}">Berbayar</a></li>
              @endif
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="{{ url('/kontak') }}">Kontak</a></li>
          @if (isset($_COOKIE['my_key']))
            <li class="dropdown">
              <a href="#">
                <span>{{ $user->user_name }}</span> <i class="bi bi-chevron-down"></i>
              </a>
              <ul>
                <li><a href="{{ url('/logout') }}">Logout</a></li>
              </ul>
            </li>
          @else
            <li><a class="getstarted scrollto" href="{{ url('/masuk') }}">Masuk</a></li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->