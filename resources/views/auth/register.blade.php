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
                                    <div class="mb-2 form-floating">
                                        {!! Form::text('name',null,['placeholder' => trans('messages.name'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.name') </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        {!! Form::text('email',null,['placeholder' => trans('messages.email'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.email') </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        {!! Form::text('phone_number',null,['placeholder' => trans('messages.phone_number'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.phone_number') </label>
                                    </div>
                                    <div class="mb-2 form-floating">
                                        {!! Form::text('city',null,['placeholder' => trans('messages.city'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.city') </label>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('email') }} </span>
                                    <div class="password-with-toggler input-group floating-input-group flex-nowrap">
                                        <div class="mb-2 form-floating flex-grow-1">
                                            <input type="password" name="password" class="password form-control" placeholder="@lang('messages.password')">
                                            <label> @lang('messages.password') </label>
                                        </div>
                                        <span class="input-group-text"><i class="bi bi-eye-slash cursor-pointer toggle-password active" area-hidden="true"></i></span>
                                    </div>
                                    <span class="text-danger"> {{ $errors->first('password') }} </span>
                                    <div class="mb-2 form-floating mt-4">
                                        <button type="submit" class="btn btn-rounded btn-primary w-100 py-2 d-flex align-items-center justify-content-center">
                                        @lang('messages.register')
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <p class="mt-3"> @lang('messages.dont_have_account')? <a href="{{ route('register') }}" class="d-inline-block"> @lang('messages.register') </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection