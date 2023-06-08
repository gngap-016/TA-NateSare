<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="dist/assets/img/logo.png" alt="">
        <span>Sinau</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto {{ (!Request::is('materies') ? 'active' : '') }}" href="#hero">Beranda</a></li>
          <li><a class="nav-link scrollto" href="#about">Tentang</a></li>
          <li><a class="nav-link scrollto" href="#services">Layanan</a></li>
          <li><a class="{{ (Request::is('materies') ? 'active' : '') }}" href="{{ url('/materies') }}">Materi</a></li>

          <li><a class="nav-link scrollto" href="{{ url('/kontak') }}">Kontak</a></li>
          <li><a class="getstarted scrollto" href="{{ url('/masuk') }}">Masuk</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->