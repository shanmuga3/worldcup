@extends('app')
@section('main')
<main class="main-container" ng-controller="authController">
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 m-auto">
                    <div class="login-wrap widget-taber-content p-30 background-white border-radius-10">
                        <div class="card">
                            <div class="card-body bg-white">
                                <div class="text-center mb-2">
                                    <h2 class="mb-2 text-black fw-bold"> @lang('messages.register') </h2>
                                </div>
                                {!! Form::open(['url' => route('create_user'), 'class' => 'form--auth form--register']) !!}
                                <div class="form__content">
                                    <div class="form-floating mt-2">
                                        {!! Form::text('first_name',null,['placeholder' => trans('messages.first_name'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.first_name') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('first_name') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('last_name',null,['placeholder' => trans('messages.last_name'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.last_name') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('last_name') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('email',null,['placeholder' => trans('messages.email'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.email') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('email') }} </span>
                                    <div class="mt-2 password-with-toggler input-group floating-input-group flex-nowrap">
                                        <div class="form-floating flex-grow-1">
                                            <input type="password" name="password" class="password form-control" placeholder="@lang('messages.password')">
                                            <label> @lang('messages.password') </label>
                                        </div>
                                        <span class="input-group-text"><i class="bi bi-eye-slash cursor-pointer toggle-password active" area-hidden="true"></i></span>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('password') }} </span>
                                    <div class="form-floating mt-2">
                                        <select name="gender" class="form-select">
                                            <option value=""> @lang('messages.select') </option>
                                            <option value="male" ng-selected="{{ old('gender') == 'male' ? true : false }}"> @lang('messages.male') </option>
                                            <option value="female" ng-selected="{{ old('gender') == 'female' ? true : false }}"> @lang('messages.female') </option>
                                            <option value="other" ng-selected="{{ old('gender') == 'other' ? true : false }}"> @lang('messages.other') </option>
                                        </select>
                                        <label> @lang('messages.gender') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('gender') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('dob',null,['placeholder' => trans('messages.dob'),'class' =>'form-control','id' => 'dob'])!!}
                                        <label> @lang('messages.dob') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('dob') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('phone_number',null,['placeholder' => trans('messages.phone_number'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.phone_number') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('phone_number') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('address',null,['placeholder' => trans('messages.address'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.address') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('address') }} </span>
                                    <div class="form-floating mt-2">
                                        {!! Form::text('city',null,['placeholder' => trans('messages.city'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.city') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('city') }} </span>
                                    
                                    <div class="form-floating mt-4">
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