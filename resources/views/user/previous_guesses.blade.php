@extends('app')
@section('main')
<main class="main-container" ng-controller="previousGuessController">
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
                            <div class="match-item">                                
                                <div class="match-header px-4 py-3 d-flex">
                                    <p class="h4"> {{ getDateObject($guess->match->starting_at)->format('d/m/Y') }} </p>
                                    <div class="user-score ms-auto h4">
                                        <div class="d-md-flex align-items-center">
                                            @if($guess->answer)
                                                @if($guess->score > 0)
                                                <p class="h5 text-success fw-bold"> {{ '+'.$guess->score }} @lang('messages.points') </p>
                                                @else
                                                <p class="h5 text-danger fw-bold"> 0 @lang('messages.points') </p>
                                                @endif
                                                @else
                                                <p class="h5"> @lang('messages.score_pending') </p>
                                            @endif
                                            @if($guess->canEditScore())
                                            <button type="button" class="btn btn-primary btn-edit-score ms-3 d-flex align-items-center" ng-click="openUpdateForm({{$guess}})">
                                              <span class="d-none d-md-block"> @lang('messages.edit') </span>
                                              <i class="fa-solid fa-edit ms-md-3"></i>
                                            </button>
                                            @endif                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="upcoming-match border">
                                    <div class="single-team">
                                        <div class="part-logo me-4">
                                             <img src="{{ $guess->match->first_team->image_src }}" alt="{{ $guess->match->first_team->name }}">
                                             <div class="d-block d-md-none mobile-result">
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
                                             <div class="d-block d-md-none mobile-result">
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
                                        </div>
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
    <div class="modal fade" id="updatePredictionModal" tabindex="-1" aria-labelledby="updatePredictionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updatePredictionModalLabel"> @lang('messages.update_prediction') </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body @{{ isLoading ? 'loading' : '' }}">
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
          </div>
          <div class="modal-footer @{{ isLoading ? 'd-none' : '' }}">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> @lang('messages.close') </button>
            <button type="button" class="btn btn-primary" ng-click="updatePrediction()"> @lang('messages.save_changes') </button>
          </div>
        </div>
      </div>
    </div>
</main>
@endsection