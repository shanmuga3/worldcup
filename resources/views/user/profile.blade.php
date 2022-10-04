@extends('app')
@section('main')
<main class="main-container">
	<section id="recent-posts" class="recent-posts sections-bg bg-image-red">
		<div class="container" data-aos="fade-up">
			<div class="section-header">
				<h2> @lang('messages.edit_profile') </h2>
			</div>
			<div class="row mt-2">
				<div class="col-lg-6 m-auto" ng-cloak>
					<div class="login-wrap widget-taber-content p-30 background-white border-radius-10">
						<div class="card ">
							<div class="card-body ">
								{!! Form::open(['url' => route('update_profile'), 'class' => 'form--auth form--register','files' => true]) !!}
								<div class="form__content">
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.full_name') <em class="text-danger"> * </em> </label>
										{!! Form::text('full_name',$user->full_name,['placeholder' => trans('messages.full_name'),'class' =>'form-control','readonly' => true])!!}
										<span class="text-danger"> {{ $errors->first('full_name') }} </span>
									</div>
									{{--
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.last_name') <em class="text-danger"> * </em> </label>
										{!! Form::text('last_name',$user->last_name,['placeholder' => trans('messages.last_name'),'class' =>'form-control','readonly' => true])!!}
										<span class="text-danger"> {{ $errors->first('last_name') }} </span>
									</div>
									--}}
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.email') <em class="text-danger"> * </em> </label>
										{!! Form::text('email',$user->email,['placeholder' => trans('messages.email'),'class' =>'form-control','readonly' => true])!!}
										<span class="text-danger"> {{ $errors->first('email') }} </span>
									</div>
									<div class="form-group">
										<label class="form-label">
											@lang('messages.password')
											<span class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="@lang('messages.password_rule')">
												<i class="fa-solid fa-circle-info"></i>
											</span>
											<em class="text-danger"> * </em>
										</label>
										<div class="input-group mt-2 password-with-toggler">
											<input type="password" name="password" class="password form-control" placeholder="@lang('messages.password')" value="" autocomplete="off">
											<span class="input-group-text"><i class="bi bi-eye-slash cursor-pointer toggle-password active" area-hidden="true"></i></span>
										</div>
										<span class="text-danger"> {{ $errors->first('password') }} </span>
									</div>
									<div class="form-group">
                                        <label class="form-label"> @lang('messages.password_confirmation') <em class="text-danger"> * </em> </label>
                                        <div class="input-group mt-2 password-with-toggler">
                                            <input type="password" name="password_confirmation" class="password form-control" placeholder="@lang('messages.password')">
                                            <span class="input-group-text"><i class="bi bi-eye-slash cursor-pointer toggle-password active" area-hidden="true"></i></span>
                                        </div>
                                        <span class="text-danger"> {{ $errors->first('password_confirmation') }} </span>
                                    </div>
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.gender') <em class="text-danger"> * </em> </label>
										<select name="gender" class="form-select">
											<option value="male" ng-selected="{{ old('gender',$user->gender) == 'male' ? true : false }}"> @lang('messages.male') </option>
											<option value="female" ng-selected="{{ old('gender',$user->gender) == 'female' ? true : false }}"> @lang('messages.female') </option>
										</select>
										<span class="text-danger"> {{ $errors->first('gender') }} </span>
									</div>
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.dob') <em class="text-danger"> * </em> </label>
										{!! Form::text('dob',$user->dob,['placeholder' => trans('messages.dob'),'class' =>'form-control','id' => 'dob'])!!}
									</div>
									<span class="text-danger"> {{ $errors->first('dob') }} </span>
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.phone_number') <em class="text-danger"> * </em> </label>
										{!! Form::text('phone_number',$user->phone_code.$user->phone_number,['placeholder' => '05xxxxxxxxxx','class' =>'form-control phone_number','maxlength' => 10,'readonly' => true])!!}
										<span class="text-danger"> {{ $errors->first('phone_number') }} </span>
									</div>
									<div class="mb-3">
										<label for="profile_picture" class="form-label"> @lang('messages.profile_picture') </label>
										<input type="file" name="profile_picture" class="form-control" id="profile_picture">
										<span class="text-danger"> {{ $errors->first('profile_picture') }} </span>
									</div>
									<div class="mb-3">
										<img src="{{ $user->profile_picture_src }}" class="img img-fluid" alt="{{ $user->first_name }}" width="120">
									</div>
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.address') <em class="text-danger"> * </em> </label>
										{!! Form::text('address',$user->address,['placeholder' => trans('messages.address'),'class' =>'form-control'])!!}
										<span class="text-danger"> {{ $errors->first('address') }} </span>
									</div>
									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.city') <em class="text-danger"> * </em> </label>
										{!! Form::select('city',resolve("City")->pluck('name','id'),$user->city,['placeholder' => trans('messages.select'),'class' =>'form-select'])!!}
										<span class="text-danger"> {{ $errors->first('city') }} </span>
									</div>

									<div class="form-group mt-2">
										<label class="form-label"> @lang('messages.favourite_team') </label>
										<select name="fav_team" id="favourite-team" class="form-select" placeholder="@lang('messages.select')">
											<option value=""> @lang('messages.select') </option>
											@foreach(resolve("Team")->sortBy('name') as $team)
											<option data-img-src="{{ $team->image_src }}" value="{{ $team->id }}" ng-selected="{{ $team->id == $user->team_id ? 'true' : 'false'}}"> {{ $team->name }} </option>
											@endforeach
										</select>
									</div>
									
									<div class="form-group mt-4">
										<button type="submit" class="btn btn-rounded btn-primary w-100 py-2 d-flex align-items-center justify-content-center">
										@lang('messages.update')
										</button>
									</div>
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
@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
        flatpickr('#dob', {
            maxDate: 'today',
            altInput: true,
            disableMobile: true,
            altFormat: flatpickrFormat,
            dateFormat: "Y-m-d",
        });
    });
</script>
@endpush