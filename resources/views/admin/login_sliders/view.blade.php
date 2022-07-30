@extends('admin.app')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<div class="fs-3"> {{ $sub_title }} </div>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">{{ $sub_title }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="conainer-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<h4 class="card-title"> {{ $sub_title }} </h4>
								@checkPermission('create-login_sliders')
								<a href="{{ route('admin.login_sliders.create') }}" class="btn btn-primary btn-round ms-auto">
									@lang('admin_messages.sliders.add_slider')
								</a>
								@endcheckPermission
							</div>
						</div>
						<div class="card-body">
							{!! $dataTable->table() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('admin_assets/plugins/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin_assets/plugins/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endpush