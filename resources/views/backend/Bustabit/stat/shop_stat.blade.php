@extends('backend.White.layouts.app')

@section('page-title', '매장충환전내역')
@section('page-heading', '매장충환전내역')

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
							@if (!auth()->user()->hasRole('manager'))
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>매장</label>
									<input class="form-control" name="name" value="{{Request::get('name') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>파트너이름</label>
									<input class="form-control" name="user" value="{{ Request::get('user') }}">
								</div>
							</div>
							@endif
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>충환전타입</label>
									{!! Form::select('type', ['' => '모두', 'add' => '충전', 'out' => '환전', 'deal_out' => '롤링전환', 'ggr_out' => '벳윈전환'], Request::get('type'), ['id' => 'type', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>계좌정보</label>
									<select name="in_out" class="form-control">
										<option value="" @if (Request::get('in_out') == '') selected @endif>@lang('app.all')</option>
										<option value="1" @if (Request::get('in_out') == '1') selected @endif>있음</option>
										<option value="0" @if (Request::get('in_out') == '0') selected @endif>없음</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최소금액</label>
									<input class="form-control" name="sum_from" value="{{ Request::get('sum_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최대금액</label>
									<input class="form-control" name="sum_to" value="{{ Request::get('sum_to') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>기간</label>
									<input class="form-control" name="dates" value="{{ Request::get('dates') }}">
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
									<th class="text-xs font-weight-normal opacity-7 px-2">매장</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">파트너이름</th>
									@if (auth()->user()->isInoutPartner())
									<th class="text-xs font-weight-normal opacity-7 px-2">파트너보유금</th>
									@endif
									<th class="text-xs font-weight-normal opacity-7 px-2">이전포인트</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">이후포인트</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">충전</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">환전</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">롤링전환</th>
									@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
									<th class="text-xs font-weight-normal opacity-7 px-2">벳윈전환</th>
									@endif
									<th class="text-xs font-weight-normal opacity-7 px-2">계좌정보</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">예금주</th>
									<th class="text-xs font-weight-normal opacity-7 px-2">시간</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$totalin=0;
									$totalout=0;
									$totaldealout=0;
									$totalggrout=0;
								?>
								@if (count($shops_stat))
									@foreach ($shops_stat as $stat)
										@include('backend.White.stat.partials.row_shop_stat')
										<?php
											if ($stat->type == 'add'){ $totalin = $totalin + abs($stat->sum);}
											if ($stat->type == 'out'){ $totalout = $totalout + abs($stat->sum);}
											if ($stat->type == 'deal_out'){ $totaldealout = $totaldealout + abs($stat->sum);}
											if ($stat->type == 'ggr_out'){ $totalggrout = $totalggrout + abs($stat->summ);}
										?>
									@endforeach
									<td></td>
									<td><p class="text-danger text-sm font-weight-normal mb-0">합계</p></td>
									@if (auth()->user()->isInoutPartner())
									<td></td>
									@endif						
									<td></td>
									<td></td>
									<td><p class="text-success text-sm font-weight-normal mb-0">{{number_format($totalin,0)}}</p></td>
									<td><p class="text-danger text-sm font-weight-normal mb-0">{{number_format($totalout,0)}}</p></td>
									<td><p class="text-danger text-sm font-weight-normal mb-0">{{number_format($totaldealout,0)}}</p></td>
									@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
									<td><p class="text-danger text-sm font-weight-normal mb-0">{{number_format($totalggrout,0)}}</p></td>
									@endif
									<td></td>
									<td></td>
									<td></td>
								@else
									<tr><td colspan="7">@lang('app.no_data')</td></tr>
								@endif
							</tbody>
						</table>
					</div>
					{{ $shops_stat->appends(Request::except('page'))->links() }}
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
				startDate: moment().subtract(30, 'day'),
				endDate: moment().add(7, 'day'),

				locale: {
					format: 'YYYY-MM-DD HH:mm'
				}
			});
		});
	</script>
@endpush