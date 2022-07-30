@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Social Media Links</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Social Media Links</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => route('admin.social_media_links.update'), 'class' => 'form-horizontal','method' => "PUT"]) !!}
					<div class="card">
						<div class="card-header">
							<div class="card-title"> {{ $sub_title }} </div>
						</div>
						<div class="card-body">
							@foreach($social_media_links as $media)
							<div class="form-group">
								<label for="{{ $media->name }}"> @lang('admin_messages.social_media_links.'.$media->name) </label>
								{!! Form::text($media->name, old($media->name,$media->value), ['class' => 'form-control', 'id' => $media->name]) !!}
								<span class="text-danger">{{ $errors->first($media->name) }}</span>
							</div>
							@endforeach
						</div>
						<div class="card-body">
							<button type="reset" class="btn btn-danger"> @lang('admin_messages.common.reset') </button>
							<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection