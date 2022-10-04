@extends('app')
@section('main')
<main class="main-container">
	<section id="recent-posts" class="recent-posts sections-bg bg-image-red">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2> @lang('messages.match_schedule') </h2>
			</div>
			<div class="row mt-2">
				<div class="col-lg-12" ng-cloak>
					<img class="img w-100" src="{{ asset('images/match_schedule.png') }}">
				</div>
			</div>
		</div>
	</section>
</main>
@endsection