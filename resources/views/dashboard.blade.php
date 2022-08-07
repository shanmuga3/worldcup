@extends('app')
@section('main')
<main class="main-container" ng-controller="dashboardController">
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
			<div class="row gy-4" ng-cloak>
				<div class="col-md-6" ng-class="{'loading':isActiveLoading}">
                    <div class="card single-match-wrapper">
                        <div class="card-header">
                            <h5 class="match-title h3 mb-0 text-white"> @lang('messages.today_matches') </h5>
                        </div>
                        <div class="card-body">
                        	<div class="text-center" ng-if="active_matches.length == 0">
                        		@lang('messages.no_active_matches')
                        	</div>
                        	<div class="part-team" ng-repeat="match in active_matches">
	                            <div class="single-team">
	                                <div class="logo">
	                                    <img ng-src="@{{ match.first_team_image }}" alt="@{{ match.first_team_name }}">
	                                </div>
	                                <span class="team-name"> @{{ match.first_team_formatted_name }} </span>
	                            </div>
	                            <div class="match-details">
	                                <div class="match-time">
	                                    <span class="date"> @{{ match.duration }} </span>
	                                    <span class="time"> @{{ match.match_time }} </span>
	                                </div>
	                                <span class="versus">@lang('messages.vs')</span>
	                                <div class="buttons">
	                                    <a href="javascript:;" class="btn btn-primary" ng-click="predictNow(match)" ng-hide="showPredictionForm"> @lang('messages.predict_now') </a>
	                                </div>
	                            </div>
	                            <div class="single-team">
	                                <div class="logo">
	                                	<img ng-src="@{{match.second_team_image}}" alt="@{{ match.second_team_name }}">
	                                </div>
	                                <span class="team-name"> @{{ match.second_team_formatted_name }} </span>
	                            </div>
                        	</div>
                        	<div class="prediction-form" ng-if="showPredictionForm">
                        		<div class="row">
                        			<div class="col-5">
                        				<div class="form-group mb-2">
                        					<label class="form-label"> @lang('messages.first_team_score') </label>
                        					<input type="text" name="first_team_score" class="form-control" ng-model="prediction_form.first_team_score">
                        					<span class="text-danger"> @{{ error_messages.first_team_score[0] }} </span>
                        				</div>
                        				<div class="form-group mb-2" ng-show="prediction_form.first_team_score != '' && prediction_form.first_team_score == prediction_form.second_team_score">
                        					<label class="form-label"> @lang('messages.first_team_penalty') </label>
                        					<input type="text" name="first_team_penalty" class="form-control" ng-model="prediction_form.first_team_penalty">
                        					<span class="text-danger"> @{{ error_messages.first_team_penalty[0] }} </span>
                        				</div>
                        			</div>
                        			<div class="col-2">
                        				
                        			</div>
                        			<div class="col-5">
                        				<div class="form-group mb-2">
                        					<label class="form-label"> @lang('messages.first_team_score') </label>
                        					<input type="text" name="second_team_score" class="form-control" ng-model="prediction_form.second_team_score">
                        					<span class="text-danger"> @{{ error_messages.second_team_score[0] }} </span>
                        				</div>
                        				<div class="form-group mb-2" ng-show="prediction_form.first_team_score != '' && prediction_form.first_team_score == prediction_form.second_team_score">
                        					<label class="form-label"> @lang('messages.second_team_penalty') </label>
                        					<input type="text" name="second_team_penalty" class="form-control" ng-model="prediction_form.second_team_penalty">
                        					<span class="text-danger"> @{{ error_messages.second_team_penalty[0] }} </span>
                        				</div>
                        			</div>
                        		</div>
                        		<div class="d-flex justify-content-around">
                                    <a href="javascript:;" class="btn btn-defalut" ng-click="hidePrediction();"> @lang('messages.cancel') </a>
                                    <a href="javascript:;" class="btn btn-primary" ng-click="submitPrediction()"> @lang('messages.submit') </a>
                                </div>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" ng-class="{'loading':isUpcomingLoading}">
                    <div class="card upcoming-match-wrapper">
                        <div class="card-header">
                            <h5 class="h3 mb-0"> @lang('messages.upcoming_matches') </h5>
                        </div>
                        <div class="card-body upcoming-matches-list">
                        	<div class="text-center" ng-if="upcoming_matches.length == 0">
                        		@lang('messages.no_upcoming_matches')
                        	</div>
                            <div class="upcoming-match" ng-repeat="match in upcoming_matches">
                                <div class="single-team">
                                    <div class="part-logo me-4">
                                         <img ng-src="@{{ match.first_team_image }}" alt="@{{ match.first_team_name }}">
                                    </div>
                                    <div class="part-text">
                                        <span class="team-name"> @{{ match.first_team_formatted_name }} </span>
                                    </div>
                                </div>
                                <span class="versus">@lang('messages.vs')</span>
                                <div class="single-team">
                                    <div class="part-text">
                                        <span class="team-name"> @{{ match.second_team_formatted_name }} </span>
                                    </div>
                                    <div class="part-logo">
                                         <img ng-src="@{{ match.second_team_image }}" alt="@{{ match.second_team_name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
</main>
@endsection