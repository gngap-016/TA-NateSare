@extends('layouts.main')

@section('content')

<main id="main">
  
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
    <div class="container">

        <ol>
        <li><a href="index.html">Home</a></li>
        <li>Blog</li>
        </ol>
        <h2>{{ $title }}</h2>

    </div>
    </section><!-- End Breadcrumbs -->

      <!-- ======= Blog Section ======= -->
      <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
  
          <div class="row">
  
            <div class="col-lg-8 entries">

                <div class="row">

                    @foreach ($materies as $matery)
                        <div class="col-md-6">
                            <article class="entry">
    
                                <div class="entry-img">
                                    <img src="{{ env('SERVER_URL') . 'storage/' . $matery->post_image }}" alt="{{ $matery->post_title }}" class="img-fluid">
                                </div>
                
                                <h2 class="entry-title">
                                    <a href="{{ url('materi/' . $matery->post_slug) }}">
                                        {{ $matery->post_title }}
                                    </a>
                                </h2>
                
                                <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="{{ url('materi/' . $matery->post_slug) }}">{{ $matery->post_author }}</a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="{{ url('materi/' . $matery->post_slug) }}"><time datetime="2020-01-01">{{ $matery->post_published_at }}</time></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="{{ url('materi/' . $matery->post_slug) }}">{{ $matery->post_total_comments }}</a></li>
                                </ul>
                                </div>
                
                                <div class="entry-content">
                                <p>{{ $matery->post_excerpt }}</p>
                                <div class="read-more">
                                    <a href="{{ url('materi/' . $matery->post_slug) }}">Baca materi</a>
                                </div>
                                </div>
                
                            </article><!-- End blog entry -->
                        </div>
                    @endforeach
    
                </div>
  
              {{-- <div class="blog-pagination">
                <ul class="justify-content-center">
                  <li><a href="#">1</a></li>
                  <li class="active"><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                </ul>
              </div> --}}
  
            </div><!-- End blog entries list -->
  
            <div class="col-lg-4">
  
              @include('layouts.sidebar')
  
            </div><!-- End blog sidebar -->
  
          </div>
  
        </div>
      </section><!-- End Blog Section -->
  
    </main><!-- End #main -->
@endsection