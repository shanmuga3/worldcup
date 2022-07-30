<div class="card">
    <div class="card-header">
        <div class="card-title"> {{ $sub_title }} </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="first_name"> @lang('admin_messages.fields.first_name') <em class="text-danger"> * </em> </label>
            {!! Form::text('first_name', $result->first_name, ['class' => 'form-control', 'id' => 'first_name']) !!}
            <span class="text-danger">{{ $errors->first('first_name') }}</span>
        </div>
        <div class="form-group">
            <label for="last_name"> @lang('admin_messages.fields.last_name') <em class="text-danger"> * </em> </label>
            {!! Form::text('last_name', $result->last_name, ['class' => 'form-control', 'id' => 'last_name']) !!}
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        </div>
        <div class="form-group">
            <label for="email"> @lang('admin_messages.fields.email_address') <em class="text-danger"> * </em> </label>
            {!! Form::text('email', $result->email, ['class' => 'form-control', 'id' => 'email']) !!}
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>
        <div class="form-group">
            <label for="password"> @lang('admin_messages.fields.password') <em class="text-danger"> * </em> </label>
            {!! Form::text('password', '', ['class' => 'form-control', 'id' => 'password']) !!}
            <span class="text-danger">{{ $errors->first('password') }}</span>
        </div>
        <div class="form-group">
            <label for="dob"> @lang('admin_messages.fields.dob') <em class="text-danger"> * </em> </label>
            {!! Form::text('dob', optional($result->user_information)->dob, ['class' => 'form-control', 'id' => 'dob']) !!}
            <span class="text-danger">{{ $errors->first('dob') }}</span>
        </div>
        <div class="form-group">
            <label for="gender"> @lang('admin_messages.fields.gender') <em class="text-danger"> * </em> </label>
            {!! Form::select('gender', ["Male"=> Lang::get('messages.account_settings.male'),"Female"=> Lang::get('messages.account_settings.female'),"Other"=> Lang::get('messages.account_settings.other')],optional($result->user_information)->gender, ['class' => 'form-select', 'id' => 'gender']) !!}
        </div>
        <div class="form-group">
            <label for="country_code"> @lang('admin_messages.fields.country_code') </label>
            {!! Form::select('country_code', $countries ,$result->country_code, ['class' => 'form-select', 'id' => 'country_code','placeholder' => Lang::get('admin_messages.common.select')]) !!}
        </div>
        <div class="form-group">
            <label for="phone_number"> @lang('admin_messages.fields.phone_number') </label>
            {!! Form::number('phone_number',$result->phone_number, ['class' => 'form-control','id' => 'phone_number']) !!}
            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
        </div>
        @if($result->id != '')
        <div class="form-group input-file input-file-image">
            <img class="img-upload-preview" src="{{ $result->profile_picture_src }}">
            <input type="file" class="form-control form-control-file" id="profile_picture" name="profile_picture" accept="image/*">
            <label for="profile_picture" class="label-input-file btn btn-default btn-round">
                <span class="btn-label"><i class="fa fa-file-image"></i></span>
                @lang('admin_messages.common.choose_file')
            </label>
            <span class="text-danger d-block">{{ $errors->first('image') }}</span>
        </div>
        @else
        <div class="form-group input-file input-file-image">
            <img class="img-upload-preview">
            <input type="file" class="form-control form-control-file" id="profile_picture" name="profile_picture" accept="image/*">
            <label for="profile_picture" class="label-input-file btn btn-default btn-round">
                <span class="btn-label"><i class="fa fa-file-image"></i></span>
                @lang('admin_messages.common.choose_file')
            </label>
            <span class="text-danger d-block">{{ $errors->first('image') }}</span>
        </div>
        @endif
        <div class="form-group">
            <label for="status"> @lang('admin_messages.fields.status') <em class="text-danger"> * </em> </label>
            {!! Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), $result->status, ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get('admin_messages.common.select')]) !!}
            <span class="text-danger">{{ $errors->first('status') }}</span>
        </div>
        @if($result->id != '' && $result->verification_status != 'no')
        <div class="form-group">
            <label for="verification_status"> @lang('admin_messages.users.verification_status') </label>
            {!! Form::select('verification_status', array('pending' => 'Pending', 'verified' => 'Verified', 'resubmit' => 'Resubmit'), $result->verification_status, ['class' => 'form-select', 'id' => 'verification_status','v-model' => 'verification_status']) !!}
            <span class="text-danger"> {{ $errors->first('verification_status') }} </span>
        </div>
        <div class="form-group" v-show="verification_status == 'resubmit'">
            <label for="resubmit_reason"> @lang('admin_messages.users.resubmit_reason') </label>
            {!! Form::textarea('resubmit_reason',$result->resubmit_reason, ['class' => 'form-control', 'id' => 'resubmit_reason','rows' => '3']) !!}
            <span class="text-danger"> {{ $errors->first('id_resubmit_reason') }} </span>
        </div>
        <div class="form-group">
            <label for="verification_document"> @lang('admin_messages.users.verification_document') </label>
            <div class="row">
                <div class="form-group input-file input-file-image">
                    <img class="img-upload-preview" src="{{ $result->user_document_src }}">
                </div>
            </div>
            <span class="text-danger"> {{ $errors->first('verification_status') }} </span>
        </div>
        @endif
    </div>
    <div class="card-body">
        <a href="{{ route('admin.users')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
        <button type="submit" class="btn btn-primary float-end" id="add"> @lang('admin_messages.common.submit') </button>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    window.vueInitData = {!! json_encode([
        'verification_status' => old('verification_status',$result->verification_status),
    ]) !!}
    $(document).ready(function() {
        var flatpickrOptions = {
            altInput: true,
            maxDate: 'today',
            altFormat: flatpickrFormat,
            dateFormat: "Y-m-d",
        };

        flatpickr('#dob', flatpickrOptions);
    });
</script>
@endpush