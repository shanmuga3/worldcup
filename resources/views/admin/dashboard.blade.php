@extends('admin.app')
@section('content')
<main class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<div class="fs-3">Dashboard</div>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-6">
					<div class="small-box bg-indigo">
						<div class="inner">
							<h3> {{ $dashboard_data['statistics_data']['users']['count'] }} </h3>
							<p> Users</p>
						</div>
						<div class="icon">
							<i class="fas fa-users"></i>
						</div>
						<a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-end"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-secondary">
						<div class="inner">
							<h3>{{ $dashboard_data['statistics_data']['teams']['count'] }}</h3>
							<p> Teams</p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
						<a href="{{ route('admin.teams') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-end"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3>{{ $dashboard_data['statistics_data']['matches']['count'] }}</h3>
							<p> Matches</p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
						<a href="{{ route('admin.matches') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-end"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-primary">
						<div class="inner">
							<h3>{{ $dashboard_data['statistics_data']['guesses']['count'] }}</h3>
							<p> Guesses </p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
						<a href="{{ route('admin.matches') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-end"></i></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"> Top Users </h3>
						</div>
						<div class="card-body p-0">
							<ul class="users-list clearfix">
								@foreach($top_users as $user)
								<li>
									<a class="users-list-name my-3" href="{{ $user['link'] }}">
										<img src="{{ $user['profile_picture'] }}" alt="{{ $user['name'] }}">
										<h5> {{ $user['name'] }} </h5>
									</a>
									<h4 class="text-black h3 fw-bold badge bg-primary"> {{ $user['score'] }} </h4>
								</li>
								@endforeach
							</ul>
						</div>
						<div class="card-footer text-center">
							<a href="{{ route('admin.users') }}">View All Users</a>
						</div>
					</div>
				</div>
				<div class="col-md-6" ng-init="today_matches={{ $today_matches }}">
					<div class="card upcoming-match-wrapper">
						<div class="card-header">
							<h3 class="card-title"> Today Matches </h3>
						</div>
						<div class="card-body p-0 upcoming-matches-list">
                        	<div class="text-center" ng-if="today_matches.length == 0">
                        		@lang('messages.no_upcoming_matches')
                        	</div>
                            <div class="upcoming-match" ng-repeat="match in today_matches">
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
						<div class="card-footer text-center">
							<a href="{{ route('admin.matches') }}">View All Matches</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection