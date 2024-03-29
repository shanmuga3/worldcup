@extends('app')
@section('main')
<main class="main-container">
	<section id="recent-posts" class="recent-posts sections-bg bg-image-red">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2> @lang('messages.groups') </h2>
			</div>
			<div class="row mt-2">
				<div class="col-lg-12" ng-cloak>
					<img class="img w-100" src="{{ asset('images/groups.png') }}">
				</div>
			</div>
		</div>
	</section>
</main>
@endsection