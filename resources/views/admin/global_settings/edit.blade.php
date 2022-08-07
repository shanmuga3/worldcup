@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Global Settings</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Global Settings</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => route('admin.global_settings.update'), 'class' => 'form-horizontal','method' => "PUT",'files' => true]) !!}
					<div class="card">
						<div class="card-header">
							<div class="card-title"> {{ $sub_title }} </div>
						</div>
						<div class="card-body">
							<div class="form-group mb-2">
								<label for="site_name"> @lang('admin_messages.global_settings.site_name') <em class="text-danger"> * </em> </label>
								{!! Form::text('site_name', old('site_name',global_settings('site_name')), ['class' => 'form-control', 'id' => 'site_name']) !!}
								<span class="text-danger">{{ $errors->first('site_name') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="about"> @lang('admin_messages.global_settings.about') <em class="text-danger"> * </em> </label>
								{!! Form::textarea('about', old('about',global_settings('about')), ['class' => 'form-control', 'id' => 'about','rows' => 3]) !!}
								<span class="text-danger">{{ $errors->first('about') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="version"> @lang('admin_messages.global_settings.version') <em class="text-danger"> * </em> </label>
								{!! Form::text('version', old('version',global_settings('version')), ['class' => 'form-control', 'id' => 'version']) !!}
								<span class="text-danger">{{ $errors->first('version') }}</span>
							</div>
							<div class="form-group mb-2 input-file input-file-image">
								<label for="primary_logo" class="form-label"> @lang('admin_messages.global_settings.primary_logo') </label>
								<img class="img-upload-preview dt-thumb-image" src="{{ $site_logo ?? asset('images/logos/logo.png') }}">
								<input type="file" name="primary_logo" class="form-control form-control-file my-3" id="primary_logo" accept="image/*">
								<span class="text-danger d-block">{{ $errors->first('primary_logo') }}</span>
							</div>
							<div class="form-group mb-2 input-file input-file-image">
								<label for="favicon" class="form-label"> @lang('admin_messages.global_settings.favicon') </label>
								<img class="img-upload-preview dt-thumb-image" src="{{ $favicon ?? asset('images/logos/favicon.png') }}">
								<input type="file" name="favicon" class="form-control form-control-file my-3" id="favicon" accept="image/*">
								<span class="text-danger d-block">{{ $errors->first('favicon') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="maintenance_mode"> @lang('admin_messages.global_settings.maintenance_mode') <em class="text-danger"> * </em> </label>
								{!! Form::select('maintenance_mode', ['up' => 'No', 'down' => 'Yes'], old('maintenance_mode',$maintenance_mode), ['class' => 'form-select', 'id' => 'maintenance_mode']) !!}
								<span class="text-danger"> {{ $errors->first('maintenance_mode') }} </span>
								@if(global_settings('maintenance_mode_secret') != '')
								<div class="mt-2 h4">
									<span> @lang('admin_messages.global_settings.maintenance_mode_secret'): </span>
									<span class="mt-2 fw-bold"> {{ global_settings('maintenance_mode_secret') }} </span>
								</div>
								@endif
							</div>
							<div class="form-group mb-2">
								<label for="admin_url"> @lang('admin_messages.global_settings.admin_url') <em class="text-danger"> * </em> </label>
								{!! Form::text('admin_url', old('admin_url',global_settings('admin_url')), ['class' => 'form-control', 'id' => 'admin_url']) !!}
								<span class="text-danger">{{ $errors->first('admin_url') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="upload_driver"> @lang('admin_messages.global_settings.upload_driver') <em class="text-danger"> * </em> </label>
								{!! Form::select('upload_driver', $upload_drivers, old('upload_driver',global_settings('upload_driver')), ['class' => 'form-select', 'id' => 'upload_driver']) !!}
								<span class="text-danger">
									{{ $errors->first('upload_driver') }}
								</span>
							</div>
							<div class="form-group mb-2">
								<label for="support_number"> @lang('admin_messages.global_settings.support_number') <em class="text-danger"> * </em> </label>
								{!! Form::text('support_number', old('support_number',global_settings('support_number')), ['class' => 'form-control', 'id' => 'support_number']) !!}
								<span class="text-danger">{{ $errors->first('support_number') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="support_email"> @lang('admin_messages.global_settings.support_email') *</label>
								{!! Form::text('support_email', old('support_email',global_settings('support_email')), ['class' => 'form-control', 'id' => 'support_email']) !!}
								<span class="text-danger">{{ $errors->first('support_email') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="date_format"> @lang('admin_messages.global_settings.date_format') <em class="text-danger"> * </em> </label>
								{!! Form::select('date_format', $date_formats, old('date_format',global_settings('date_format')), ['class' => 'form-select', 'id' => 'date_format']) !!}
								<span class="text-danger">
									{{ $errors->first('date_format') }}
								</span>
							</div>
							<div class="form-group mb-2">
								<label for="default_user_status"> @lang('admin_messages.global_settings.default_user_status') <em class="text-danger"> * </em> </label>
								{!! Form::select('default_user_status',array('pending' => Lang::get('admin_messages.status.pending'),'active' => Lang::get('admin_messages.common.active'), 'inactive' => Lang::get('admin_messages.common.inactive')) , old('default_user_status',global_settings('default_user_status')), ['class' => 'form-select', 'id' => 'default_user_status']) !!}
								<span class="text-danger">
									{{ $errors->first('default_user_status') }}
								</span>
							</div>
							<div class="form-group mb-2">
								<label for="backup_period"> @lang('admin_messages.global_settings.how_many_days_store_database') <em class="text-danger"> * </em> </label>
								{!! Form::select('backup_period',$backup_period_array,old('backup_period',global_settings('backup_period')), ['class' => 'form-select', 'id' => 'backup_period']) !!}
								<span class="text-danger"> {{ $errors->first('backup_period') }} </span>
							</div>
							<div class="form-group mb-2">
								<label for="user_inactive_days"> @lang('admin_messages.global_settings.user_inactive_days') <em class="text-danger"> * </em> </label>
								{!! Form::text('user_inactive_days', old('user_inactive_days',global_settings('user_inactive_days')), ['class' => 'form-control', 'id' => 'user_inactive_days']) !!}
								<span class="text-danger">{{ $errors->first('user_inactive_days') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="copyright_link"> @lang('admin_messages.global_settings.copyright_link') <em class="text-danger"> * </em> </label>
								{!! Form::text('copyright_link', old('copyright_link',global_settings('copyright_link')), ['class' => 'form-control', 'id' => 'copyright_link']) !!}
								<span class="text-danger">{{ $errors->first('copyright_link') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="copyright_text"> @lang('admin_messages.global_settings.copyright_text') <em class="text-danger"> * </em> </label>
								{!! Form::text('copyright_text', old('copyright_text',global_settings('copyright_text')), ['class' => 'form-control', 'id' => 'copyright_text']) !!}
								<span class="text-danger">{{ $errors->first('copyright_text') }}</span>
							</div>
							<div class="form-group mb-2">
								<label for="head_code"> @lang('admin_messages.global_settings.head_code') <span class="d-block h6"> @lang('admin_messages.global_settings.head_code_desc') </span> </label>
								{!! Form::textarea('head_code', old('head_code',global_settings('head_code')), ['rows' => 3, 'class' => 'form-control', 'id' => 'head_code']) !!}
								<span class="text-danger">
									{{ $errors->first('head_code') }}
								</span>
							</div>
							<div class="form-group mb-2">
								<label for="foot_code"> @lang('admin_messages.global_settings.foot_code') <span class="d-block h6"> @lang('admin_messages.global_settings.foot_code_desc') </span> </label>
								{!! Form::textarea('foot_code', old('foot_code',global_settings('foot_code')), ['rows' => 3, 'class' => 'form-control', 'id' => 'foot_code']) !!}
								<span class="text-danger">
									{{ $errors->first('foot_code') }}
								</span>
							</div>
						</div>
						<div class="card-body">
							<a href="{{ route('admin.global_settings') }}" class="btn btn-danger"> @lang('admin_messages.common.cancel') </a>
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