@extends('backend.White.layouts.app')

@section('page-title', '공지관리')
@section('page-heading', '공지관리')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4">
			<div class="col-12">
				<div class="card card-body">
					<div class="d-flex">
						<a href="{{ route('backend.notice.create') }}" class="btn bg-gradient-primary ms-auto">공지 추가</a>
					</div>
					<div class="table-responsive">
						<table class="table align-items-center mb-0">
							<thead>
							<tr>
								<th class="text-xs font-weight-bolder opacity-7 px-2">제목</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">등록날짜</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">공지대상</th>
								@if (auth()->user()->hasRole('admin'))
								<th class="text-xs font-weight-bolder opacity-7 px-2">작성자</th>
								@endif
								<th class="text-xs font-weight-bolder opacity-7 px-2">상태</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@if (count($notices))
								@foreach ($notices as $notice)
									@include('backend.White.notices.partials.row')
								@endforeach
							@else
								<tr><td colspan="6">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
