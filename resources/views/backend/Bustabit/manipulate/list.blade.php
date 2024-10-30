@extends('backend.White.layouts.app')

@section('page-title', '게임조작')
@section('page-heading', '게임조작')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="card card-body mt-4">
			<div class="table-responsive">
				<div class="d-flex">
					<a href="{{ route('backend.manipulate.create') }}" class="btn btn-sm bg-gradient-primary ms-auto">추가</a>
				</div>
				<table class="table align-items-center mb-0">
					<thead>
						<tr>
							<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.id')</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">회원아이디</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">유형</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">조작금액</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금</th>
							<th class="text-xs font-weight-bolder opacity-7 px-2">시작시간</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@if (count($activeManipulates))
							@foreach ($activeManipulates as $idx => $manipulate)
								@include('backend.White.manipulate.partials.row')
							@endforeach
						@else
							<tr><td colspan="8">@lang('app.no_data')</td></tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>

		<div class="card mt-4">
			<div class="card-header">
				<h5>조작내역</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table align-items-center mb-0">
						<thead>
							<tr>
								<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.id')</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">회원아이디</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">유형</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">조작금액</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">시작시간</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">마감시간</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.status')</th>
							</tr>
						</thead>
						<tbody>
							@if (count($oldManipulates))
								@foreach ($oldManipulates as $idx => $manipulate)
									@include('backend.White.manipulate.partials.row')
								@endforeach
							@else
								<tr><td colspan="8">@lang('app.no_data')</td></tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection