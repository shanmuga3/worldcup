@extends('app')
@section('main')
<main class="main-container" ng-controller="authController">
    <section class="pt-5 pb-5 bg-image-red">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 m-auto">
                    <div class="login-wrap widget-taber-content p-30 background-white border-radius-10">
                        <div class="card">
                            <div class="card-body bg-white">
                                <div class="text-center mb-2">
                                    <h2 class="mb-2 text-black fw-bold"> @lang('messages.register') </h2>
                                </div>
                                {!! Form::open(['url' => route('create_user'), 'class' => 'form--auth form--register','files' => true]) !!}
                                <div class="form__content">
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.full_name') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('full_name',null,['placeholder' => trans('messages.full_name'),'class' =>'form-control'])!!}
                                        <span class="text-danger"> {{ $errors->first('full_name') }} </span>
                                    </div>
                                    {{--
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.last_name') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('last_name',null,['placeholder' => trans('messages.last_name'),'class' =>'form-control'])!!}
                                        <span class="text-danger"> {{ $errors->first('last_name') }} </span>
                                    </div>
                                    --}}
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.email') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('email',null,['placeholder' => trans('messages.email'),'class' =>'form-control'])!!}
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
                                            <input type="password" name="password" class="password form-control" placeholder="@lang('messages.password')">
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
                                            <option value=""> @lang('messages.select') </option>
                                            <option value="male" ng-selected="{{ old('gender') == 'male' ? true : false }}"> @lang('messages.male') </option>
                                            <option value="female" ng-selected="{{ old('gender') == 'female' ? true : false }}"> @lang('messages.female') </option>
                                        </select>
                                        <span class="text-danger"> {{ $errors->first('gender') }} </span>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.dob') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('dob',null,['placeholder' => trans('messages.dob'),'class' =>'form-control','id' => 'dob'])!!}
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('dob') }} </span>
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.phone_number') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('phone_number',null,['placeholder' => '05xxxxxxxxxx','class' =>'form-control phone_number','maxlength' => 10])!!}
                                        <span class="text-danger"> {{ $errors->first('phone_number') }} </span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label"> @lang('messages.profile_picture') </label>
                                        <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                                        <span class="text-danger"> {{ $errors->first('profile_picture') }} </span>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.address') <em class="text-danger"> * </em> </label>
                                        {!! Form::text('address',null,['placeholder' => trans('messages.address'),'class' =>'form-control'])!!}
                                        <span class="text-danger"> {{ $errors->first('address') }} </span>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label class="form-label"> @lang('messages.city') <em class="text-danger"> * </em> </label>
                                        {!! Form::select('city',resolve("City")->pluck('name','id'),null,['placeholder' => trans('messages.select'),'class' =>'form-select'])!!}
                                        <span class="text-danger"> {{ $errors->first('city') }} </span>
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-rounded btn-primary w-100 py-2 d-flex align-items-center justify-content-center">
                                        @lang('messages.register')
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <p class="mt-3"> @lang('messages.already_have_account')? <a href="{{ route('login') }}" class="d-inline-block"> @lang('messages.sign_in') </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection