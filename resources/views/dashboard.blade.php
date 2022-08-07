@extends('app')
@section('main')
<main class="main-container">
	<section id="hero" class="hero-dashboard">
		<div class="container team position-relative">
			<div class="row gy-4 py-5">
				<div class="col-xl-3 col-md-6 d-flex {{ isRtl() ? 'offset-xl-6' : '' }}" data-aos="fade-up" data-aos-delay="100">
					<div class="member">
						<img src="{{ $user->profile_picture_src }}" class="img-fluid" alt="">
						<h4> {{ $user->full_name }} </h4>
						<span> {{ $user->email }} </span>
						@if($user->address != '')
						<span> {{ $user->address }} </span>
						@endif
						@if($user->city != '')
						<span> {{ $user->city }} </span>
						@endif
						@if($user->formatted_dob != '')
						<span> {{ $user->formatted_dob }} </span>
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
				<h2> @lang('messages.featured_matches') </h2>
			</div>
			<div class="row gy-4">
				<div class="col-md-6">
                    <div class="card single-match-wrapper">
                        <div class="card-header">
                            <h5 class="match-title h3 mb-0 text-white"> @lang('messages.today_matches') </h5>
                        </div>
                        <div class="card-body part-team">
                            <div class="single-team">
                                <div class="logo">
                                    <img src="assets/img/team-1.png" alt="">
                                </div>
                                <span class="team-name">Khulna Tigers</span>
                            </div>
                            <div class="match-details">
                                <div class="match-time">
                                    <span class="date">Fri 09 Oct 2019</span>
                                    <span class="time">09:00 am</span>
                                </div>
                                <span class="versus">vs</span>
                                <div class="buttons">
                                    <a href="#" class="btn btn-primary"> @lang('messages.predict_now') </a>
                                </div>
                            </div>
                            <div class="single-team">
                                <div class="logo">
                                    <img src="assets/img/team-2.png" alt="">
                                </div>
                                <span class="team-name">Dhaka Platoon</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card upcoming-match-wrapper">
                        <div class="card-header">
                            <h5 class="h3 mb-0"> @lang('messages.upcoming_matches') </h5>
                        </div>
                        <div class="card-body upcoming-matches-list">
                        	@foreach([1,2,3,4,5] as $match)
                            <div class="upcoming-match">
                                <div class="single-team">
                                    <div class="part-logo me-4">
                                         <img src="assets/img/team-1.png" alt="">
                                    </div>
                                    <div class="part-text">
                                        <span class="team-name">
                                            Khulna tigers
                                        </span>
                                    </div>
                                </div>
                                <span class="versus">vs</span>
                                <div class="single-team">
                                    <div class="part-text">
                                        <span class="team-name">
                                            dhaka platoon
                                        </span>
                                    </div>
                                    <div class="part-logo">
                                         <img src="assets/img/team-2.png" alt="">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
</main>
@endsection