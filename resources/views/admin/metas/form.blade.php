<div class="card">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="display_name"> @lang('admin_messages.fields.name') <em class="text-danger">*</em> </label>
			{!! Form::text('display_name', $result->display_name, ['class' => 'form-control disabled', 'id' => 'display_name','readonly' => 'readonly']) !!}
			<span class="text-danger">{{ $errors->first('display_name') }}</span>
		</div>
		<div class="form-group">
			<label for="title"> @lang('admin_messages.fields.title') <em class="text-danger">*</em> </label>
			{!! Form::text('title', old('title',$result->title), ['class' => 'form-control', 'id' => 'title']) !!}
			<span class="text-danger">{{ $errors->first('title') }}</span>
		</div>
		<div class="form-group">
			<label for="description"> @lang('admin_messages.fields.description') </label>
			{!! Form::text('description', old('description',$result->description), ['class' => 'form-control', 'id' => 'description']) !!}
			<span class="text-danger">{{ $errors->first('description') }}</span>
		</div>
		<div class="form-group">
			<label for="keywords"> @lang('admin_messages.fields.keywords') </label>
			{!! Form::text('keywords', old('keywords',$result->keywords), ['class' => 'form-control', 'id' => 'keywords']) !!}
			<span class="text-danger">{{ $errors->first('keywords') }}</span>
		</div>
	</div>
	@include('admin.translation')
	<div class="card-body">
		<a href="{{ route('admin.metas') }}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>