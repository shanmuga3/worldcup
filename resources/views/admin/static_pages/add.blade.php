@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<div class="fs-3"> {{ $sub_title }} </div>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item">
							<a href="{{ route('admin.static_pages') }}">@lang("admin_messages.navigation.static_pages")</a>
						</li>
						<li class="breadcrumb-item active">{{ $sub_title }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => route('admin.static_pages.store'), 'class' => 'form-horizontal','files' => true]) !!}
					@include('admin.static_pages.form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection