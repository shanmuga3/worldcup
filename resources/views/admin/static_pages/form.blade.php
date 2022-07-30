<div class="card">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="name"> @lang('admin_messages.fields.name') <em class="text-danger">*</em> </label>
			{!! Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'name']) !!}
			<span class="text-danger">{{ $errors->first('name') }}</span>
		</div>

		<div class="form-group">
			<label for="content"> @lang('admin_messages.fields.content') <em class="text-danger">*</em> </label>
			<textarea name="content" class="form-control rich-text-editor" id="content">{{ $result->content }}</textarea>
			<span class="text-danger">{{ $errors->first('content') }}</span>
		</div>

		<div class="form-group">
			<label for="must_agree"> @lang('admin_messages.fields.must_agree') <em class="text-danger">*</em> </label>
			{!! Form::select('must_agree', $yes_no_array, $result->must_agree, ['class' => 'form-select', 'id' => 'must_agree', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('must_agree') }}</span>
		</div>

		<div class="form-group">
			<label for="in_footer"> @lang('admin_messages.fields.footer') <em class="text-danger">*</em> </label>
			{!! Form::select('in_footer', $yes_no_array, $result->in_footer, ['class' => 'form-select', 'id' => 'in_footer', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('in_footer') }}</span>
		</div>

		<div class="form-group">
			<label for="under_section"> @lang('admin_messages.fields.under_section') </label>
			{!! Form::select('under_section', FOOTER_SECTIONS, $result->under_section, ['class' => 'form-select', 'id' => 'under_section', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('under_section') }}</span>
		</div>
		
		<div class="form-group">
			<label for="status"> @lang('admin_messages.fields.status') <em class="text-danger">*</em> </label>
			{!! Form::select('status', $status_array, $result->status, ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('status') }}</span>
		</div>
	</div>
	@include('admin.translation')	
	<div class="card-body">
		<a href="{{ route('admin.static_pages')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>