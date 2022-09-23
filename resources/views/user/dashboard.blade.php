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
						@if($user->city_name != '')
						<span> {{ $user->city_name }} </span>
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
							<h2 class="fw-bold score mb-3">
								{{ $user->score }}
							</h2>
							<div class="share-score d-flex justify-content-center py-2 border-top">
								<iframe class="me-3" src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Findomieksa&width=60&layout=button&action=like&size=large&share=false&height=60&appId=632632744403634" width="60" height="65" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture;"></iframe>
								<a href="https://twitter.com/indomieksa?ref_src=twsrc%5Etfw" class="ms-3 twitter-follow-button" data-size="large" data-show-screen-name="false" data-show-count="false">Follow</a>
							</div>
							<h5 class="">
								@lang('messages.number_of_guess'): <strong class="text-success"> {{ $user->total_predictions }} </strong>
							</h5>
							<div class="help border-top">
								<a href="javascript:;" role="button" data-bs-toggle="modal" data-bs-target="#earnPointsModal">
								  <h4 class="dropdown-toggle"> @lang('messages.how_earn_points') </h4>
								</a>
								{{--
								<div class="dropdown">
								  <a class="" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
									<h4 class="dropdown-toggle"> @lang('messages.how_earn_points') </h4>
								  </a>
								  <ul class="dropdown-menu px-3" aria-labelledby="dropdownMenuButton1">
									<li> <p class="mb-2"> @lang('messages.point_desc_1') </p> </li>
									<li> <p class="mb-2"> @lang('messages.point_desc_2') </p> </li>
									<li> <p class="mb-2"> @lang('messages.point_desc_3') </p> </li>
									<li> <p class="mb-2"> @lang('messages.point_desc_4') </p> </li>
									<li> <p class="mb-2"> @lang('messages.point_desc_5') </p> </li>
									<li> <p class="mb-2"> @lang('messages.point_desc_6') </p> </li>
								  </ul>
								</div>
								--}}
							</div>
							<div class="favourite-team mt-2 border-top">
								<h4 class="mb-3"> @lang('messages.favourite_team') </h4>
								@if($user->team_logo != '')
									<img class="img" src="{{ $user->team_logo }}" alt="{{ $user->team->short_name }}" title="{{ $user->team->short_name }}">
									<span class="fw-bold"> {{ $user->team->name }} </span>
								@else
								<select name="fav_team" id="favourite-team" class="form-select" placeholder="@lang('messages.select')">
									<option value=""> @lang('messages.select') </option>
									@foreach(resolve("Team") as $team)
									<option data-img-src="{{ $team->image_src }}" value="{{ $team->id }}"> {{ $team->name }} </option>
									@endforeach
								</select>
								@endif
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
                        	<div class="today-matches mb-3" ng-repeat="match in active_matches">
	                        	<div class="part-team">
		                            <div class="single-team">
		                                <div class="logo">
		                                    <img ng-src="@{{ match.first_team_image }}" alt="@{{ match.first_team_name }}">
		                                </div>
		                                <span class="team-name"> @{{ match.first_team_formatted_name }} </span>
		                            </div>
		                            <div class="match-details">
		                                <div class="match-time" dir="ltr">
		                                    <span class="date"> @{{ match.duration }} </span>
		                                    <span class="time match-timer" data-id="@{{ match.id }}" data-time="@{{ match.ending_at }}">
	                                    	<div class="d-flex justify-content-center" id="timer_@{{ match.id }}">
												<div id="hours_@{{ match.id }}"></div>
												<div id="minutes_@{{ match.id }}"></div>
												<div id="seconds_@{{ match.id }}"></div>
											</div>
	                                    </span>
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
	                        	<div class="prediction-form" ng-if="showPredictionForm && active_match.id == match.id">
	                        		<div class="row">
	                        			<div class="col-5">
	                        				<div class="form-group mb-2">
	                        					<label class="form-label"> @lang('messages.first_team_score') </label>
	                        					<input type="text" name="first_team_score" class="form-control" ng-model="prediction_form.first_team_score" maxlength="2">
	                        					<span class="text-danger"> @{{ error_messages.first_team_score[0] }} </span>
	                        				</div>
	                        				<div class="form-group mb-2" ng-show="active_match.round > 1 && prediction_form.first_team_score != '' && prediction_form.first_team_score == prediction_form.second_team_score">
	                        					<label class="form-label"> @lang('messages.first_team_penalty') </label>
	                        					<input type="text" name="first_team_penalty" class="form-control" ng-model="prediction_form.first_team_penalty" maxlength="2">
	                        					<span class="text-danger"> @{{ error_messages.first_team_penalty[0] }} </span>
	                        				</div>
	                        			</div>
	                        			<div class="col-2">
	                        				
	                        			</div>
	                        			<div class="col-5">
	                        				<div class="form-group mb-2">
	                        					<label class="form-label"> @lang('messages.first_team_score') </label>
	                        					<input type="text" name="second_team_score" class="form-control" ng-model="prediction_form.second_team_score" maxlength="2">
	                        					<span class="text-danger"> @{{ error_messages.second_team_score[0] }} </span>
	                        				</div>
	                        				<div class="form-group mb-2" ng-show="active_match.round > 1 && prediction_form.first_team_score != '' && prediction_form.first_team_score == prediction_form.second_team_score">
	                        					<label class="form-label"> @lang('messages.second_team_penalty') </label>
	                        					<input type="text" name="second_team_penalty" class="form-control" ng-model="prediction_form.second_team_penalty" maxlength="2">
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
                                    <div class="part-text d-none d-md-block">
                                        <span class="team-name"> @{{ match.first_team_formatted_name }} </span>
                                    </div>
                                </div>
                                <span class="versus">@lang('messages.vs')</span>
                                <div class="single-team">
                                    <div class="part-text d-none d-md-block">
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
	<div class="modal fade" id="earnPointsModal" tabindex="-1" aria-labelledby="earnPointsLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="earnPointsLabel">@lang('messages.how_earn_points')</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <ul class="list-group px-3">
	        	{{--
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_1') </p> </li>
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_2') </p> </li>
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_3') </p> </li>
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_4') </p> </li>
	        	--}}
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_5') </p> </li>
				<li class="list-group-item"> <p class="mb-2"> @lang('messages.point_desc_6') </p> </li>
			  </ul>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> @lang('messages.close') </button>
	      </div>
	    </div>
	  </div>
	</div>

</main>
@endsection
@push('scripts')
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endpush