<div class="card">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group mb-2">
			<label for="short_name"> @lang('admin_messages.fields.short_name') <em class="text-danger">*</em> </label>
			{!! Form::text('short_name', $result->short_name, ['class' => 'form-control', 'id' => 'short_name']) !!}
			<span class="text-danger">{{ $errors->first('short_name') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="name"> @lang('admin_messages.fields.name') <em class="text-danger">*</em> </label>
			{!! Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'name']) !!}
			<span class="text-danger">{{ $errors->first('name') }}</span>
		</div>
		<div class="form-group mb-2 input-file input-file-image">
			<img class="img-upload-preview dt-thumb-image" src="{{ $result->image_src ?? asset('images/preview_thumbnail.png') }}">
			<input type="file" class="form-control my-3 form-control-file" id="image" name="image" accept="image/*">
			<span class="text-danger d-block">{{ $errors->first('image') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="status"> @lang('admin_messages.fields.status') <em class="text-danger">*</em> </label>
			{!! Form::select('status', $status_array, $result->status, ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('status') }}</span>
		</div>
	</div>
	<div class="card-footer">
		<a href="{{ route('admin.teams')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>