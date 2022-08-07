@extends('app')
@section('main')
<main class="main-container">
	<section id="hero" class="hero-dashboard">
		<div class="container team position-relative">
			<div class="row gy-4 py-5">
				<div class="col-xl-3 col-md-6 d-flex {{ isRtl() ? 'offset-xl-6' : '' }}" data-aos="fade-up" data-aos-delay="100">
					<div class="member">
						<img src="{{ $user->profile_picture_src }}" class="img-fluid" alt="">
						<h4> {{ $user->name }} </h4>
						<span> {{ $user->email }} </span>
						@if($user->address != '')
						<span> {{ $user->address }} </span>
						@endif
						@if($user->city != '')
						<span> {{ $user->city }} </span>
						@endif
						@if($user->dob != '')
						<span> {{ $user->dob }} </span>
						@endif
						@if($user->gender != '')
						<span> @lang('messages.'.$user->gender) </span>
						@endif
					</div>
				</div>
				<div class="col-xl-3 col-md-6 d-flex {{ isRtl() ? '' : 'offset-xl-6' }}" data-aos="fade-up" data-aos-delay="200">
					<div class="member">
						<div class="card-header">
							<h3 class="text-center"> @lang('messages.score') </h3>
						</div>
						<div class="card-body">
							<h2 class="fw-bold score mb-3"> {{ $user->score }} </h2>
							<div class="help border-top">
								<h4> @lang('messages.how_earn_points') </h4>
								<ul class="list-unstyled">
									<li> <p class="text-small mb-0"> @lang('messages.point_desc_1') </p> </li>
									<li> <p class="text-small mb-0"> @lang('messages.point_desc_2') </p> </li>
									<li> <p class="text-small mb-0"> @lang('messages.point_desc_3') </p> </li>
									<li> <p class="text-small mb-0"> @lang('messages.point_desc_4') </p> </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="recent-posts" class="recent-posts sections-bg">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2> @lang('messages.upcoming_matches') </h2>
			</div>
			<div class="row gy-4">
				<div class="col-xl-4 col-md-6">
					<article>
						<div class="post-img">
							<img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
						</div>
						<p class="post-category">Politics</p>
						<h2 class="title">
						<a href="blog-details.html">Dolorum optio tempore voluptas dignissimos</a>
						</h2>
						<div class="d-flex align-items-center">
							<img src="assets/img/blog/blog-author.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
							<div class="post-meta">
								<p class="post-author">Maria Doe</p>
								<p class="post-date">
									<time datetime="2022-01-01">Jan 1, 2022</time>
								</p>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection