@extends('app')
@section('main')
<main class="main-container">
	<section class="pt-5 pb-5 bg-image-red">
		<div class="container">
			<div class="wrapper">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form">
								<h3 class="text-center"> @lang('messages.set_new_password') </h3>
								{!! Form::open(['url' => route('set_password'), 'class' => '','id'=>'set_password_form']) !!}
								{!! Form::hidden('email',$email) !!}
								{!! Form::hidden('reset_token',$reset_token) !!}
								<div class="form-floating mb-2">
									<input type="password" name="password" class="form-control" placeholder="@lang('messages.new_password')">
									<label for="password" class="form-label"> @lang('messages.new_password') </label>
								</div>
								<div class="form-floating mb-2">
									<input type="password" name="password_confirmation" class="form-control" placeholder="@lang('messages.confirm_password')">
									<label for="password_confirmation" class="form-label"> @lang('messages.confirm_password') </label>
								</div>
								<span class="text-danger"> {{ $errors->first('password') }} </span>
								<div class="form-group mt-4">
									<button type="submit" class="btn btn-primary d-flex w-100 justify-content-center">
									@lang('messages.update_password')
									</button>
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection