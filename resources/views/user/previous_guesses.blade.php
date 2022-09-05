@extends('app')
@section('main')
<main class="main-container" ng-controller="dashboardController">
	<section id="recent-posts" class="recent-posts sections-bg">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2> @lang('messages.your_previous_guesses') </h2>
			</div>
			<div class="row gy-4" ng-cloak>
                <div class="col-md-12">
                    <div class="card upcoming-match-wrapper">
                        <div class="card-body upcoming-matches-list">
                        	@foreach($user_guesses as $guess)
                            <div class="upcoming-match border-bottom">
                                <div class="single-team">
                                    <div class="part-logo me-4">
                                         <img src="{{ $guess->match->first_team->image_src }}" alt="{{ $guess->match->first_team->name }}">
                                    </div>
                                    <div class="part-text d-none d-md-block">
                                        <p class="team-name fw-bold"> {{ $guess->match->first_team->formatted_name }} </p>
                                        <p class="user-guess">
                                            <span class="fw-bold mx-2"> @lang('messages.guess'):</span>
                                        	{{ $guess->first_team_score }}
	                                        @if($guess->first_team_penalty != '')
	                                        <span class="user-penalty"> ({{ $guess->first_team_penalty }}) </span>
	                                        @endif
                                        </p>
                                        @if($guess->match->answer == 1)
                                        <p class="match-result">
                                            <span class="fw-bold mx-2"> @lang('messages.result'):</span>
                                            {{ $guess->match->first_team_score }}
                                            @if($guess->match->first_team_penalty != '')
                                            <span class="user-penalty"> ({{ $guess->match->first_team_penalty }}) </span>
                                            @endif
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <span class="versus">@lang('messages.vs')</span>
                                <div class="single-team">
                                    <div class="part-text d-none d-md-block">
                                        <p class="team-name fw-bold"> {{ $guess->match->second_team->formatted_name }} </p>
                                        <p class="user-guess">
                                            <span class="fw-bold mx-2"> @lang('messages.guess'):</span>
                                        	{{ $guess->second_team_score }}
                                        	@if($guess->second_team_penalty != '')
	                                        <span class="user-penalty"> ({{ $guess->second_team_penalty }}) </span>
	                                        @endif
                                        </p>
                                        @if($guess->match->answer == 1)
                                        <p class="match-result">
                                            <span class="fw-bold mx-2"> @lang('messages.result'):</span>
                                            {{ $guess->match->second_team_score }}
                                            @if($guess->match->second_team_penalty != '')
                                            <span class="user-penalty"> ({{ $guess->match->second_team_penalty }}) </span>
                                            @endif
                                        </p>
                                        @endif
                                    </div>
                                    <div class="part-logo {{ isRtl() ? 'me-4' : 'ms-4' }}">
                                         <img src="{{ $guess->match->second_team->image_src }}" alt="{{ $guess->match->second_team->name }}">
                                    </div>
                                </div>
                                <div class="user-score me-2">
                                	@if($guess->answer)
                                	@if($guess->score > 0)
                                	<p class="h5 text-success fw-bold"> {{ '+'.$guess->score }} @lang('messages.points') </p>
                                	@else
                                	<p class="h5 text-danger fw-bold"> 0 @lang('messages.points') </p>
                                	@endif
                                	@else
                                	<p class="h5"> @lang('messages.pending') </p>
                                	@endif
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