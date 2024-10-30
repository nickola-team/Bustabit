@extends('backend.White.layouts.app')

@section('page-title', '잭팟설정')
@section('page-heading', '잭팟설정')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="card card-body mt-4">
			<div class="table-responsive">
				@permission('happyhours.add')
				<div class="d-flex">
					<a href="{{ route('backend.happyhour.create') }}" class="btn bg-gradient-primary ms-auto">잭팟 추가</a>
				</div>
				@endpermission
				<table class="table align-items-center mb-0">
					<thead>
						<tr>
							<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.id')</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">회원아이디</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">총 당첨금</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">남은당첨금</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">초과당첨금</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">유형</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.time')</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.status')</th>
						</tr>
					</thead>
					<tbody>
						@if (count($happyhours))
							@foreach ($happyhours as $happyhour)
								@include('backend.White.happyhours.partials.row')
							@endforeach
						@else
							<tr><td colspan="8">@lang('app.no_data')</td></tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection