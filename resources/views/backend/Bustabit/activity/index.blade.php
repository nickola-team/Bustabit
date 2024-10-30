@extends('backend.White.layouts.app')

@section('page-title', '접속로그')
@section('page-heading', '접속로그')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="col-12">
				<form action="" method="GET">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title ">@lang('app.filter')</h5>
					</div>
					<div class="card-body pt-0">
						<div class="row">
							<div class="col-md-4">
								<div class="input-group input-group-static">
									<label>이름(아이디)</label>
									<input class="form-control" name="username" value="{{ Request::get('username') }}" >
								</div>
							</div>

							<div class="col-md-4">
								<div class="input-group input-group-static">
									<label>@lang('app.message')</label>
									<input class="form-control" name="search" value="{{ Request::get('search') }}" >
								</div>
							</div>

							<div class="col-md-4">
								<div class="input-group input-group-static">
									<label>@lang('app.ip')</label>
									<input class="form-control" name="ip" value="{{ Request::get('ip') }}" >
								</div>
							</div>
						</div>
						<button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-3 mb-0">@lang('app.filter')</button>
					</div>
				</div>
				</form>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<div class="card card-body">
					<div class="table-responsive">
						<table class="table align-items-center mb-0">
							<thead>
								<tr>
									@if (isset($adminView))
									<th class="text-xs font-weight-bolder opacity-7 px-2">이름(아이디)</th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.ip')</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.message')</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">접속시간</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">상세정보</th>
								</tr>
							</thead>
							<tbody>
							@if (count($activities))
								@foreach ($activities as $activity)
									<tr>
										@if (isset($adminView))
											<td>
												@if (isset($user))
													{{ $activity->user->present()->username }}
												@else
													<a href="{{ route('backend.activity.user', $activity->user_id) }}">
														<p class="text-sm font-weight-bold mb-0">{{ $activity->userdata->username }}</p>
													</a>
												@endif
											</td>
										@endif
										<td><p class="text-sm font-weight-normal mb-0">{{ $activity->ip_address }}</p></td>
										<td><p class="text-sm font-weight-normal mb-0">{{ $activity->description }}</p></td>
										<td><p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($activity->created_at)) }}</p></td>
										<td><p class="text-sm font-weight-normal mb-0">{{ $activity->user_agent }}</p></td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="@if (isset($adminView)) 5 @else 4 @endif">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $activities->appends(Request::except('page'))->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection