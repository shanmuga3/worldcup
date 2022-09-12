<div class="card">
	<div class="card-header">
		<div class="card-title"> {{ $sub_title }} </div>
	</div>
	<div class="card-body">
		<div class="form-group mb-2">
			<label for="first_team"> @lang('admin_messages.matches.first_team') <em class="text-danger">*</em> </label>
			{!! Form::select('first_team',$teams, $result->first_team_id, ['class' => 'form-select', 'id' => 'first_team','placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('first_team') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="second_team"> @lang('admin_messages.matches.second_team') <em class="text-danger">*</em> </label>
			{!! Form::select('second_team',$teams, $result->second_team_id, ['class' => 'form-select', 'id' => 'second_team','placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('second_team') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="round"> @lang('admin_messages.matches.round') <em class="text-danger">*</em> </label>
			{!! Form::select('round', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5'], $result->round, ['class' => 'form-select', 'id' => 'round', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('round') }}</span>
		</div>
		{{--
		<div class="form-group mb-2">
			<label for="match_time"> @lang('admin_messages.matches.match_time') <em class="text-danger">*</em> </label>
			{!! Form::text('match_time', $result->match_time, ['class' => 'form-control', 'id' => 'match_time', 'placeholder' => Lang::get("admin_messages.matches.match_time")]) !!}
			<span class="text-danger">{{ $errors->first('match_time') }}</span>
		</div>
		--}}
		<div class="form-group mb-2">
			<label for="first_team_score"> @lang('admin_messages.matches.first_team_score') <em class="text-danger">*</em> </label>
			{!! Form::text('first_team_score', $result->first_team_score, ['class' => 'form-control', 'id' => 'first_team_score', 'placeholder' => Lang::get("admin_messages.matches.first_team_score")]) !!}
			<span class="text-danger">{{ $errors->first('first_team_score') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="second_team_score"> @lang('admin_messages.matches.second_team_score') <em class="text-danger">*</em> </label>
			{!! Form::text('second_team_score', $result->second_team_score, ['class' => 'form-control', 'id' => 'second_team_score', 'placeholder' => Lang::get("admin_messages.matches.second_team_score")]) !!}
			<span class="text-danger">{{ $errors->first('second_team_score') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="first_team_penalty"> @lang('admin_messages.matches.first_team_penalty') <em class="text-danger">*</em> </label>
			{!! Form::text('first_team_penalty', $result->first_team_penalty, ['class' => 'form-control', 'id' => 'first_team_penalty', 'placeholder' => Lang::get("admin_messages.matches.first_team_penalty")]) !!}
			<span class="text-danger">{{ $errors->first('first_team_penalty') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="starting_at"> @lang('admin_messages.matches.second_team_penalty') <em class="text-danger">*</em> </label>
			{!! Form::text('second_team_penalty', $result->second_team_penalty, ['class' => 'form-control', 'id' => 'second_team_penalty', 'placeholder' => Lang::get("admin_messages.matches.second_team_penalty")]) !!}
			<span class="text-danger">{{ $errors->first('first_team_penalty') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="starting_at"> @lang('admin_messages.matches.starting_at') <em class="text-danger">*</em> </label>
			{!! Form::text('starting_at', $result->starting_at, ['class' => 'form-control', 'id' => 'starting_at', 'placeholder' => Lang::get("admin_messages.matches.starting_at")]) !!}
			<span class="text-danger">{{ $errors->first('starting_at') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="ending_at"> @lang('admin_messages.matches.ending_at') <em class="text-danger">*</em> </label>
			{!! Form::text('ending_at', $result->ending_at, ['class' => 'form-control', 'id' => 'ending_at', 'placeholder' => Lang::get("admin_messages.matches.ending_at")]) !!}
			<span class="text-danger">{{ $errors->first('ending_at') }}</span>
		</div>
		<div class="form-group mb-2">
			<label for="answer"> @lang('admin_messages.matches.answer') <em class="text-danger">*</em> </label>
			{!! Form::select('answer', $yes_no_array, $result->answer, ['class' => 'form-select', 'id' => 'answer', 'placeholder' => Lang::get("admin_messages.common.select")]) !!}
			<span class="text-danger">{{ $errors->first('answer') }}</span>
		</div>
	</div>
	<div class="card-footer">
		<a href="{{ route('admin.matches')}}" class="btn btn-danger"> @lang('admin_messages.common.back') </a>
		<button type="submit" class="btn btn-primary float-end"> @lang('admin_messages.common.submit') </button>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var flatpickrOptions = {
            altInput: true,
            enableTime: true,
            disableMobile: true,
            time_24hr: true,
            altFormat: "Y-m-d H:i:s",
            dateFormat: "Y-m-d H:i:s",
        };

        flatpickr('#starting_at', flatpickrOptions);
        flatpickr('#ending_at', flatpickrOptions);
    });
</script>
@endpush