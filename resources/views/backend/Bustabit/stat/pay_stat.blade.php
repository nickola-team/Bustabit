@extends('backend.White.layouts.app')

@section('page-title', '회원충환전내역')
@section('page-heading', '회원충환전내역')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
				<div class="card ">
					<div class="card-header p-3 pt-2 bg-transparent">
						<div
							class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
							<i class="material-icons opacity-10">add</i>
						</div>
						<div class="text-end pt-1">
							<p class="text-sm mb-0 text-capitalize ">총 충전금액</p>
							<h4 class="mb-0 ">{{ number_format($total['add']) }}</h4>
						</div>
					</div>
					<hr class="horizontal my-0 dark">
					<div class="card-footer p-3">
						<p class="mb-0 ">방금전</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
				<div class="card ">
					<div class="card-header p-3 pt-2 bg-transparent">
						<div
							class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
							<i class="material-icons opacity-10">remove</i>
						</div>
						<div class="text-end pt-1">
							<p class="text-sm mb-0 text-capitalize ">총 환전금액</p>
							<h4 class="mb-0 ">{{ number_format($total['out']) }}</h4>
						</div>
					</div>
					<hr class="horizontal my-0 dark">
					<div class="card-footer p-3">
						<p class="mb-0 ">방금전</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4" id="toggle-box">
			<div class="col-12">
				<form action="" method="GET">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title ">@lang('app.filter')</h5>
					</div>
					<div class="card-body pt-0">
						<div class="row">
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>충/환전</label>
									<select name="type" class="form-control">
										<option value="" @if (Request::get('type') == '') selected @endif>@lang('app.all')</option>
										<option value="add" @if (Request::get('type') == 'add') selected @endif>충전</option>
										<option value="out" @if (Request::get('type') == 'out') selected @endif>환전</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>@lang('app.user')</label>
									<input type="text" class="form-control" name="user" value="{{ Request::get('user') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최소금액</label>
									<input type="text" class="form-control" name="sum_from" value="{{ Request::get('sum_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최대금액</label>
									<input type="text" class="form-control" name="sum_to" value="{{ Request::get('sum_to') }}">
								</div>
							</div>
						</div>
						<div class="row mt-2">
							@if (!auth()->user()->hasRole('manager'))
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>매장이름</label>
									<input type="text" class="form-control" name="shopname" value="{{ Request::get('shopname') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>지불자이름</label>
									<input type="text" class="form-control" name="payeername" value="{{ Request::get('payeername') }}">
								</div>
							</div>
							@endif
							<div class="col-md-6">
								<div class="input-group input-group-static">
									<label>기간</label>
									<input type="text" class="form-control" name="dates" value="{{ Request::get('dates') }}">
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
								<th class="text-xs font-weight-bolder opacity-7 px-2">이름(아이디)</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">매장관리자</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">보유금</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">이전포인트</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">이후포인트</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">충전</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">환전</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">시간</th>
							</tr>
							</thead>
							<tbody>
								@if (count($statistics))
									@foreach ($statistics as $stat)
										@if($stat instanceof \VanguardLTE\ShopStat)
											@include('backend.White.stat.partials.row_shop_stat')
										@else
											@include('backend.White.stat.partials.row_stat')
										@endif
									@endforeach
								@else
									<tr><td colspan="8">@lang('app.no_data')</td></tr>
								@endif
							</tbody>
						</table>
					</div>
					{{ $statistics->appends(Request::except('page'))->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script>
		$(function() {
			$('input[name="dates"]').daterangepicker({
				timePicker: true,
				timePicker24Hour: true,
				startDate: moment().format('YYYY-MM-DD 00:00'),
				endDate: moment().add(0, 'day'),

				locale: {
					format: 'YYYY-MM-DD HH:mm'
				}
			});
		});
	</script>
@endpush