@extends('admin.app')
@section('api_credentials')
<li class="nav-item">
	<a class="nav-link" href="#recaptcha" role="tab" data-bs-toggle="tab">
		<i class="fas fa-recycle"></i>@lang('admin_messages.credentials.recaptcha')
	</a>
</li>
@endsection
@section('cloudinary')
<div class="form-group">
	<label for="cloud_name"> @lang('admin_messages.credentials.cloud_name') <em class="text-danger"> * </em> </label>
	{!! Form::text('cloud_name', old('cloud_name',credentials('cloud_name','Cloudinary')), ['class' => 'form-control', 'id' => 'cloud_name']) !!}
	<span class="text-danger"> {{ $errors->first('cloud_name') }} </span>
</div>
<div class="form-group">
	<label for="cloud_api_key"> @lang('admin_messages.credentials.cloud_api_key') <em class="text-danger"> * </em> </label>
	{!! Form::text('cloud_api_key', old('cloud_api_key',credentials('api_key','Cloudinary')), ['class' => 'form-control', 'id' => 'cloud_api_key']) !!}
	<span class="text-danger"> {{ $errors->first('cloud_api_key') }} </span>
</div>
<div class="form-group">
	<label for="cloud_api_secret"> @lang('admin_messages.credentials.cloud_api_secret') <em class="text-danger"> * </em> </label>
	{!! Form::text('cloud_api_secret', old('cloud_api_secret',credentials('api_secret','Cloudinary')), ['class' => 'form-control', 'id' => 'cloud_api_secret']) !!}
	<span class="text-danger"> {{ $errors->first('cloud_api_secret') }} </span>
</div>
@endsection
@section('recaptcha')
<div class="form-group">
	<label for="is_recaptcha_enabled"> @lang('admin_messages.fields.is_enabled') <em class="text-danger"> * </em> </label>
	{!! Form::select('is_recaptcha_enabled',$yes_no_array, old('is_recaptcha_enabled',credentials('is_enabled','ReCaptcha')), ['class' => 'form-select', 'id' => 'is_recaptcha_enabled']) !!}
	<span class="text-danger"> {{ $errors->first('is_recaptcha_enabled') }} </span>
</div>
<div class="form-group">
	<label for="recaptcha_version"> @lang('admin_messages.credentials.recaptcha_version') <em class="text-danger"> * </em> </label>
	{!! Form::select('recaptcha_version',array('2' => Lang::get('admin_messages.credentials.version_2'),'3' => Lang::get('admin_messages.credentials.version_3')), old('recaptcha_version',credentials('recaptcha_version','ReCaptcha')), ['class' => 'form-select', 'id' => 'recaptcha_version']) !!}
	<span class="text-danger"> {{ $errors->first('recaptcha_version') }} </span>
</div>
<div class="form-group">
	<label for="site_key"> @lang('admin_messages.credentials.site_key') <em class="text-danger"> * </em> </label>
	{!! Form::text('recaptcha_site_key', old('recaptcha_site_key',credentials('site_key','ReCaptcha')), ['class' => 'form-control', 'id' => 'site_key']) !!}
	<span class="text-danger"> {{ $errors->first('recaptcha_site_key') }} </span>
</div>
<div class="form-group">
	<label for="cloud_api_secret"> @lang('admin_messages.credentials.secret_key') <em class="text-danger"> * </em> </label>
	{!! Form::text('recaptcha_secret_key', old('recaptcha_secret_key',credentials('secret_key','ReCaptcha')), ['class' => 'form-control', 'id' => 'secret_key']) !!}
	<span class="text-danger"> {{ $errors->first('recaptcha_secret_key') }} </span>
</div>
@endsection
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Credentials</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Credentials</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => $update_url, 'class' => 'form-horizontal','id'=>'credentials_form','method' => "PUT", 'files' => true]) !!}
					{!! Form::hidden('active_menu',$active_menu) !!}
					{!! Form::hidden('current_tab','',['id' => 'current_tab']) !!}
					<div class="card">
						<div class="card-header">
							<div class="card-title"> {{ $sub_title }} </div>
						</div>
						<div class="card-body">
							<div id="navigation-pills">
								<div class="title">
									<h3></h3>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-2">
												<ul class="nav nav-pills nav-pills-icons flex-column navigation-links" role="tablist">
													@yield($active_menu)
												</ul>
											</div>
											<div class="col-md-9">
												<div class="tab-content">
													<div class="tab-pane" id="cloudinary">
														@yield('cloudinary')
													</div>
													<div class="tab-pane" id="recaptcha">
														@yield('recaptcha')
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-end">
							<div class="col-md-12">
								<button type="submit" class="btn btn-round btn-primary pull-end"> @lang('admin_messages.common.submit') </button>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var default_tab = "{{ $active_menu == 'payment_gateways' ? 'stripe' : 'map' }}";
		var current_tab = getParameterByName('current_tab');
		current_tab = current_tab != '' ? current_tab : default_tab;
		$('.navigation-links').find('[href="#'+current_tab+'"]').tab('show');
		$('#'+current_tab).addClass('active show');
		setGetParameter('current_tab',current_tab)
		$('#current_tab').val(current_tab);
		$(document).on('click', '.navigation-links a',function() {
			current_tab = $(this).attr('href').substring(1);
			setGetParameter('current_tab',current_tab);
			$('#current_tab').val(current_tab);
		});
	});
</script>
@endpush