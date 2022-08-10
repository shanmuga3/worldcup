<div class="card">
    <div class="card-header">
        <div class="card-title"> {{ $sub_title }} </div>
    </div>
    <div class="card-body">
        <div class="form-group mb-2">
            <label for="first_name"> @lang('admin_messages.fields.first_name') <em class="text-danger"> * </em> </label>
            {!! Form::text('first_name', $result->first_name, ['class' => 'form-control', 'id' => 'first_name']) !!}
            <span class="text-danger">{{ $errors->first('first_name') }}</span>
        </div>
        <div class="form-group mb-2">
            <label for="last_name"> @lang('admin_messages.fields.last_name') <em class="text-danger"> * </em> </label>
            {!! Form::text('last_name', $result->last_name, ['class' => 'form-control', 'id' => 'last_name']) !!}
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        </div>
        <div class="form-group mb-2">
            <label for="email"> @lang('admin_messages.fields.email_address') <em class="text-danger"> * </em> </label>
            {!! Form::text('email', $result->email, ['class' => 'form-control', 'id' => 'email']) !!}
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>
        <div class="form-group mb-2">
            <label for="password"> @lang('admin_messages.fields.password') <em class="text-danger"> * </em> </label>
            {!! Form::text('password', '', ['class' => 'form-control', 'id' => 'password']) !!}
            <span class="text-danger">{{ $errors->first('password') }}</span>
        </div>
        <div class="form-group mb-2">
            <label for="dob"> @lang('admin_messages.fields.dob') <em class="text-danger"> * </em> </label>
            {!! Form::text('dob', $result->dob, ['class' => 'form-control', 'id' => 'dob']) !!}
            <span class="text-danger">{{ $errors->first('dob') }}</span>
        </div>
        <div class="form-group mb-2">
            <label for="gender"> @lang('admin_messages.fields.gender') <em class="text-danger"> * </em> </label>
            {!! Form::select('gender', ["Male"=> Lang::get('messages.male'),"Female"=> Lang::get('messages.female'),"Other"=> Lang::get('messages.other')],$result->gender, ['class' => 'form-select', 'id' => 'gender']) !!}
        </div>
        <div class="form-group mb-2">
            <label for="team"> @lang('admin_messages.fields.team') </label>
            {!! Form::select('team', resolve("Team")->pluck('short_name','id') ,$result->team_id, ['class' => 'form-select', 'id' => 'team','placeholder' => Lang::get('admin_messages.common.select')]) !!}
        </div>
        <div class="form-group mb-2">
            <label for="phone_number"> @lang('admin_messages.fields.phone_number') </label>
            {!! Form::number('phone_number',$result->phone_number, ['class' => 'form-control','id' => 'phone_number']) !!}
            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
        </div>
        @if($result->id != '')
        <div class="form-group mb-2 input-file input-file-image">
            <img class="img-upload-preview" src="{{ $result->profile_picture_src }}">
            <input type="file" class="form-control my-4 form-control-file" id="profile_picture" name="profile_picture" accept="image/*">
            <span class="text-danger d-block">{{ $errors->first('image') }}</span>
        </div>
        @else
        <div class="form-group mb-2 input-file input-file-image">
            <img class="img-upload-preview">
            <input type="file" class="form-control form-control-file" id="profile_picture" name="profile_picture" accept="image/*">
            <label for="profile_picture" class="label-input-file btn btn-default btn-round">
                <span class="btn-label"><i class="fa fa-file-image"></i></span>
                @lang('admin_messages.common.choose_file')
            </label>
            <span class="text-danger d-block">{{ $errors->first('image') }}</span>
        </div>
        @endif
        <div class="form-group mb-2">
            <label for="status"> @lang('admin_messages.fields.status') <em class="text-danger"> * </em> </label>
            {!! Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), $result->status, ['class' => 'form-select', 'id' => 'status', 'placeholder' => Lang::get('admin_messages.common.select')]) !!}
            <span class="text-danger">{{ $errors->first('status') }}</span>
        </div>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.users')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
        <button type="submit" class="btn btn-primary float-end" id="add"> @lang('admin_messages.common.submit') </button>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var flatpickrOptions = {
            altInput: true,
            maxDate: 'today',
            disableMobile: true,
            altFormat: flatpickrFormat,
            dateFormat: "Y-m-d",
        };

        flatpickr('#dob', flatpickrOptions);
    });
</script>
@endpush