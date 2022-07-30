<div class="card mx-2">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group mt-2">
			<label for="username"> @lang('admin_messages.fields.username') <em class="text-danger">* </em> </label>
			{!! Form::text('username', $result->username ?? '', ['class' => 'form-control', 'id' => 'username']) !!}
			<span class="text-danger">{{ $errors->first('username') }}</span>
		</div>
		<div class="form-group mt-2">
			<label for="email"> @lang('admin_messages.fields.email_address') <em class="text-danger">* </em> </label>
			{!! Form::email('email', $result->email ?? '', ['class' => 'form-control', 'id' => 'email']) !!}
			<span class="text-danger">{{ $errors->first('email') }}</span>
		</div>
		<div class="form-group mt-2">
			<label for="password"> @lang('admin_messages.fields.password') <em class="text-danger">* </em> </label>
			{!! Form::text('password', '', ['class' => 'form-control', 'id' => 'password' ]) !!}
			<span class="text-danger">{{ $errors->first('password') }}</span>
		</div>
		<div class="form-group mt-2">
			<label for="role"> @lang('admin_messages.fields.role') <em class="text-danger">* </em> </label>
			{!! Form::select('role', $roles, $role_id ?? '', ['class' => 'form-select', 'id' => 'role', 'placeholder' => Lang::get('admin_messages.common.select')]) !!}
			<span class="text-danger">{{ $errors->first('role') }}</span>
		</div>
		<div class="form-group mt-2">
			<label for="status"> @lang('admin_messages.fields.status') <em class="text-danger">* </em> </label>
			{!! Form::select('status', $status_array, $result->status ?? '', ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get('admin_messages.common.select')]) !!}
			<span class="text-danger">{{ $errors->first('status') }}</span>
		</div>
		<div class="form-group mt-2">
			<label for="primary"> @lang('admin_messages.fields.primary') <em class="text-danger">* </em> </label>
			{!! Form::select('primary', $yes_no_array, $result->primary ?? '', ['class' => 'form-select', 'id' => 'primary', 'placeholder' => Lang::get('admin_messages.common.select')]) !!}
			<span class="text-danger">{{ $errors->first('primary') }}</span>
		</div>
	</div>
	<div class="card-body">
		<a href="{{ route('admin.admin_users')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>