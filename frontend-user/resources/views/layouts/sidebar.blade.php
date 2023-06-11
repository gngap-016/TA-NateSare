<div class="sidebar">
  
    <h3 class="sidebar-title">Cari Postingan</h3>
    <div class="sidebar-item search-form">
      <form action="">
        <input type="text">
        <button type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End sidebar search formn-->

    <h3 class="sidebar-title">Categories</h3>
    <div class="sidebar-item categories">
      <ul>
        @foreach ($categories as $category)
          <li><a href="#">{{ $category->category_name }}</a></li>  
        @endforeach
      </ul>
    </div><!-- End sidebar categories-->

    {{-- <h3 class="sidebar-title">Postingan Terbaru</h3>
    <div class="sidebar-item recent-posts">
      <div class="post-item clearfix">
        <img src="assets/img/blog/blog-recent-1.jpg" alt="">
        <h4><a href="blog-single.html">Nihil blanditiis at in nihil autem</a></h4>
        <time datetime="2020-01-01">Jan 1, 2020</time>
      </div>

      <div class="post-item clearfix">
        <img src="assets/img/blog/blog-recent-2.jpg" alt="">
        <h4><a href="blog-single.html">Quidem autem et impedit</a></h4>
        <time datetime="2020-01-01">Jan 1, 2020</time>
      </div>

      <div class="post-item clearfix">
        <img src="assets/img/blog/blog-recent-3.jpg" alt="">
        <h4><a href="blog-single.html">Id quia et et ut maxime similique occaecati ut</a></h4>
        <time datetime="2020-01-01">Jan 1, 2020</time>
      </div>

      <div class="post-item clearfix">
        <img src="assets/img/blog/blog-recent-4.jpg" alt="">
        <h4><a href="blog-single.html">Laborum corporis quo dara net para</a></h4>
        <time datetime="2020-01-01">Jan 1, 2020</time>
      </div>

      <div class="post-item clearfix">
        <img src="assets/img/blog/blog-recent-5.jpg" alt="">
        <h4><a href="blog-single.html">Et dolores corrupti quae illo quod dolor</a></h4>
        <time datetime="2020-01-01">Jan 1, 2020</time>
      </div>

    </div><!-- End sidebar recent posts--> --}}

  </div><!-- End sidebar -->