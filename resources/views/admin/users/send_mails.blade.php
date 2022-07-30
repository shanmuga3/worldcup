@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Send Email to Users</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Send Email to Users</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['url' => route('admin.email_to_users'), 'class' => 'form-horizontal']) !!}
					<div class="card">
						<div class="card-header">
							<div class="card-title"> {{ $sub_title }} </div>
						</div>
						<div class="card-body">
							<div class="form-check">
								<label> @lang('admin_messages.email_to_users.mail_to') <em class="text-danger"> * </em> </label><br/>
								<label class="form-radio-label">
									<input class="form-radio-input" type="radio" name="mail_to" v-model="mail_to" value="all">
									<span class="form-radio-sign"> @lang('admin_messages.email_to_users.all_users') </span>
								</label>
								<label class="form-radio-label ms-3">
									<input class="form-radio-input" type="radio" name="mail_to" v-model="mail_to" value="specific">
									<span class="form-radio-sign"> @lang('admin_messages.email_to_users.specific_users') </span>
								</label>
								<span class="text-danger">{{ $errors->first('mail_to') }}</span>
							</div>
							<div class="form-group" :class="{'d-none' : mail_to != 'specific'}">
								<label for="emails"> @lang('admin_messages.email_to_users.emails') <em class="text-danger"> * </em></label>
								{!! Form::select('emails[]', $user_email_list,'',['class' => 'w-100 form-select', 'id' => 'emails','multiple' => 'multiple']) !!}
								<span class="text-danger">{{ $errors->first('emails') }}</span>
							</div>
							<div class="form-group">
								<label for="title"> @lang('admin_messages.email_to_users.subject') <em class="text-danger"> * </em></label>
								{!! Form::text('subject', '', ['class' => 'form-control', 'id' => 'subject']) !!}
								<span class="text-danger">{{ $errors->first('subject') }}</span>
							</div>
							<div class="form-group">
								<label for="content">
									@lang('admin_messages.fields.content') <em class="text-danger"> * </em>
									<p class="my-0 small"> (@lang('admin_messages.email_to_users.salutation_automatically_added')) </p>
								</label>
								<textarea name="content" class="form-control" id="content"></textarea>
								<span class="text-danger">{{ $errors->first('content') }}</span>
							</div>
						</div>
						<div class="card-body">
							<a href="{{ route('admin.email_to_users')}}" class="btn btn-danger"> @lang('admin_messages.common.cancel') </a>
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
@push('scripts')
<script type="text/javascript">
	window.vueInitData = {!! json_encode([
		'mail_to' => old('mail_to','all'),
	]) !!}
</script>
<script src="{{ asset('admin_assets/js/plugin/select2/select2.min.js') }}"></script>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		$('#content').summernote({
			height: 250,
		});
	});
</script>
@endpush