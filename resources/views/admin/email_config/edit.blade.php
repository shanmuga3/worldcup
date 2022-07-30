@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Email Configurations</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Email Configurations</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => route('admin.email_configurations.update'), 'class' => 'form-horizontal','method' => "PUT"]) !!}
					<div class="card">
						<div class="card-header">
							<div class="card-title"> {{ $sub_title }} </div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="driver"> @lang('admin_messages.email_config.driver') <em class="text-danger">*</em> </label>
								{!! Form::select('driver', MAIL_DRIVERS, old('driver',credentials('driver','EmailConfig')), ['class' => 'form-select', 'id' => 'driver']) !!}
								<span class="text-danger">{{ $errors->first('driver') }}</span>
							</div>
							<div class="form-group">
								<label for="host"> @lang('admin_messages.email_config.host') <em class="text-danger">*</em> </label>
								{!! Form::text('host', old('host',credentials('host','EmailConfig')), ['class' => 'form-control', 'id' => 'host']) !!}
								<span class="text-danger">{{ $errors->first('host') }}</span>
							</div>
							<div class="form-group">
								<label for="port"> @lang('admin_messages.email_config.port') <em class="text-danger">*</em> </label>
								{!! Form::text('port', old('port',credentials('port','EmailConfig')), ['class' => 'form-control', 'id' => 'port']) !!}
								<span class="text-danger">{{ $errors->first('port') }}</span>
							</div>
							<div class="form-group">
								<label for="encryption"> @lang('admin_messages.email_config.encryption') <em class="text-danger">*</em> </label>
								{!! Form::text('encryption', old('encryption',credentials('encryption','EmailConfig')), ['class' => 'form-control', 'id' => 'encryption']) !!}
								<span class="text-danger">{{ $errors->first('encryption') }}</span>
							</div>
							<div class="form-group">
								<label for="from_name"> @lang('admin_messages.email_config.from_name') <em class="text-danger">*</em> </label>
								{!! Form::text('from_name', old('from_name',credentials('from_name','EmailConfig')), ['class' => 'form-control', 'id' => 'from_name']) !!}
								<span class="text-danger">{{ $errors->first('from_name') }}</span>
							</div>
							<div class="form-group">
								<label for="from_address"> @lang('admin_messages.email_config.from_address') <em class="text-danger">*</em> </label>
								{!! Form::text('from_address', old('from_address',credentials('from_address','EmailConfig')), ['class' => 'form-control', 'id' => 'from_address']) !!}
								<span class="text-danger">{{ $errors->first('from_address') }}</span>
							</div>
							<div class="form-group">
								<label for="username"> @lang('admin_messages.email_config.username') <em class="text-danger">*</em> </label>
								{!! Form::text('username', old('username',credentials('username','EmailConfig')), ['class' => 'form-control', 'id' => 'username']) !!}
								<span class="text-danger">{{ $errors->first('username') }}</span>
							</div>
							<div class="form-group">
								<label for="app_password"> @lang('admin_messages.email_config.password') <em class="text-danger">*</em> </label>
								{!! Form::text('app_password', old('app_password',credentials('password','EmailConfig')), ['class' => 'form-control', 'id' => 'app_password']) !!}
								<span class="text-danger">{{ $errors->first('app_password') }}</span>
							</div>
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