<div class="card">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group mb-2">
			<label for="first_team"> @lang('admin_messages.matches.first_team') <em class="text-danger">*</em> </label>
			{!! Form::select('first_team',$teams, $result->first_team_id, ['class' => 'form-select', 'id' => 'first_team','placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('first_team') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="second_team"> @lang('admin_messages.matches.second_team') <em class="text-danger">*</em> </label>
			{!! Form::select('second_team',$teams, $result->second_team_id, ['class' => 'form-select', 'id' => 'second_team','placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('second_team') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="status"> @lang('admin_messages.fields.status') <em class="text-danger">*</em> </label>
			{!! Form::select('status', $status_array, $result->status, ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('status') }}</span>
		</div>
	</div>
	<div class="card-footer">
		<a href="{{ route('admin.matches')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>