<div class="card mx-2">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="input_name"> @lang('admin_messages.fields.name') <em class="text-danger"> * </em> </label>
			{!! Form::text('name', old('name',$result->name), ['class' => 'form-control', 'id' => 'input_name']) !!}
			<span class="text-danger">{{ $errors->first('name') }}</span>
		</div>
		<div class="form-group">
			<label for="input_description"> @lang('admin_messages.fields.description') <em class="text-danger"> * </em> </label>
			{!! Form::text('description', old('description',$result->description), ['class' => 'form-control', 'id' => 'input_description']) !!}
			<span class="text-danger">{{ $errors->first('description') }}</span>
		</div>
		@if(count($permissions))
		<div class="form-group">
			<label for="permission">@lang('admin_messages.fields.permission') <em class="text-danger"> * </em> </label>
			<div class="row ms-2">
				@foreach($permissions as $permission)
				<div class="col-3">
					<div class="form-check">
						<input type="checkbox" name="permission[]" class="form-check-input" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" ng-checked="{{ in_array($permission->id,$old_permissions) ? 'true':'false' }}">
						<label for="permission_{{ $permission->id }}" class="form-check-label"> {{ $permission->display_name }} </label>
					</div>
				</div>
				@endforeach
			</div>
			<span class="text-danger"> {{ $errors->first('permission') }} </span>
		</div>
		@endif
	</div>
	<div class="card-body">
		<a href="{{ route('admin.roles') }}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>