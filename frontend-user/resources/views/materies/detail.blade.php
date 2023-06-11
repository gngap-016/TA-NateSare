@extends('layouts.main')

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="{{ url('/') }}">Beranda</a></li>
          <li><a href="{{ url('/materies') }}">Materi</a></li>
          <li>{{ $matery->post_title }}</li>
        </ol>
        <h2>{{ $matery->post_title }}</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">

            <article class="entry entry-single">

              <div class="entry-img">
                <img src="{{ env('SERVER_URL') . 'storage/' . $matery->post_image }}" alt="{{ $matery->post_title }}" class="img-fluid">
              </div>

              <h2 class="entry-title">
                {{ $matery->post_title }}
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $matery->post_author }}</a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time>{{ $matery->post_published_at }}</time></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="#">{{ $matery->post_total_comments }} Diskusi</a></li>
                </ul>
              </div>

              <div class="entry-content">
                {!! $matery->post_content !!}

              </div>

              <div class="entry-footer">
                <i class="bi bi-folder"></i>
                <ul class="cats">
                  <li><a href="#">{{ $matery->post_category }}</a></li>
                </ul>
              </div>

            </article><!-- End blog entry -->

            <div class="blog-author d-flex align-items-center">
              <img src="{{ env('SERVER_URL') . 'storage/' . $matery->post_author }}" class="rounded-circle float-left" alt="{{ $matery->post_author }}">
              <div>
                <h4>{{ $matery->post_author }}</h4>
              </div>
            </div><!-- End blog author bio -->

            <div class="blog-comments">

              <h4 class="comments-count">{{ $matery->post_total_comments }} Diskusi</h4>

              @foreach ($matery->post_comments as $comment)
                <div style="height: 2px; width: 100%; background-color: rgb(35, 69, 216); border-radius: 50%"></div>
                <div class="comment">
                  <div class="d-flex">
                    <div class="comment-img"><img src="{{ env('SERVER_URL') . 'storage/' . $comment->user->image }}" alt=""></div>
                    <div>
                      <h5><a href="#">{{ $comment->user->name }}</a></h5>
                      <time>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</time>
                      {!! $comment->body !!}
                    </div>
                  </div>
                </div><!-- End comment #1 -->
                <hr><hr>
              @endforeach


              <div class="reply-form">
                <h4>Buat Diskusi Baru</h4>
                @if (isset($_COOKIE['my_key']))
                  <form action="{{ url('/materi' . '/' . $matery->post_slug) }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col form-group">
                        <input type="hidden" name="post_slug" value="{{ $matery->post_slug }}">
                        <textarea name="comment_content" class="form-control" placeholder="Your Comment*"></textarea>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                  </form>
                @else 
                  <p>Untuk membuat diskusi baru, Anda diharuskan masuk terlebih dahulu</p>
                @endif

              </div>

            </div><!-- End blog comments -->

          </div><!-- End blog entries list -->

          <div class="col-lg-4">

            @include('layouts.sidebar')

          </div><!-- End blog sidebar -->

        </div>

      </div>
    </section><!-- End Blog Single Section -->

  </main><!-- End #main -->
@endsection