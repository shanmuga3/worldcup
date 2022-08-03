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
					<!-- small box -->
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
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
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
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
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
			</div>
		</div>
	</div>
</main>
@endsection