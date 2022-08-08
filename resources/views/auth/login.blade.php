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
                                    <h2 class="mb-2 text-black fw-bold"> @lang('messages.sign_in') </h2>
                                </div>
                                {!! Form::open(['url' => route('authenticate'), 'class' => 'form--auth form--login']) !!}
                                <div class="form__content">
                                    <div class="mb-2 form-floating">
                                        {!! Form::text('email',null,['placeholder' => trans('messages.email'),'class' =>'form-control'])!!}
                                        <label> @lang('messages.email') </label>
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
                                    <div class="form-check">
                                        <a href="#" class="float-end" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                            @lang('messages.forgot_password')?
                                        </a>
                                    </div>
                                    <div class="mb-2 form-floating mt-4">
                                        <button type="submit" class="btn btn-rounded btn-primary w-100 py-2 d-flex align-items-center justify-content-center">
                                        @lang('messages.sign_in')
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <p class="mt-3"> <a href="{{ route('register') }}" class="d-inline-block"> @lang('messages.create_new_account') </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Forgot Password Modal Start -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    {!! Form::open(['url' => route('reset_password'), 'class' => '','id'=>'reset_password_form']) !!}
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="forgot_email" placeholder="@lang('messages.email')" value="{{ old('email') }}">
                        <label for="forgot_email"> @lang('messages.email') </label>
                    </div>
                    <span class="text-danger"> {{ $errors->first('email') }} </span>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary d-flex w-100 justify-content-center">
                            @lang('messages.send_reset_link')
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Modal End -->
@endsection