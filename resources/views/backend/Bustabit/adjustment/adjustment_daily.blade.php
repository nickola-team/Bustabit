@extends('backend.White.layouts.app')

@section('page-title', '일일정산')
@section('page-heading', '일일정산')

@section('content')

	@include('backend.White.partials.messages')
	
	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h5>@lang('app.filter')</h5>
					</div>
					<div class="card-body pt-0">
						<input type="hidden" name="start_date" id="start_date" value="{{ $start_date }}">
						<input type="hidden" name="end_date" id="end_date" value="{{ $end_date }}">

						<form action="" method="GET">
						<div class="row">
							@if (!auth()->user()->hasRole('manager'))
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>파트너이름</label>
									<input class="form-control" name="search" value="{{ Request::get('search') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>타입</label>
									{!! Form::select('type', ['partner' => '파트너', 'shop' => '매장'], Request::get('type'), ['id' => 'type', 'class' => 'form-control']) !!}
								</div>
							</div>
							@endif
							<div class="col-md-4">
								<div class="input-group input-group-static">
									<label>기간선택</label>
									<input class="form-control" name="dates" value="{{ Request::get('dates') }}">
								</div>
							</div>
						</div>
						<button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-3 mb-0">@lang('app.filter')</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
			<div class="card">
				<div class="card-header">
					<?php  
						$available_roles = Auth::user()->available_roles( true );
						$available_roles_trans = [];
						foreach ($available_roles as $key=>$role)
						{
							$role = \VanguardLTE\Role::find($key)->description;
							$available_roles_trans[$key] = $role;
						}
					?>
					@if($user != null)
					<a href="{{ route('backend.adjustment_daily', $user->id==auth()->user()->id?'':'parent='.$user->parent_id) }}">
						<h5 class="card-title">{{$user->username}} [ {{$available_roles_trans[$user->role_id]}} ]</h5>
					</a>
					@endif
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table align-items-center mb-0">
							<thead>
								<tr>
									<th class="text-xs font-weight-bolder opacity-7 px-2">이름</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">날짜</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">충전</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">환전</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금</th>
									@if (auth()->user()->isInoutPartner())
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링금</th>
									@else
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링금 <span class="text-success">({{ auth()->user()->hasRole('manager') ? auth()->user()->shop->deal_percent : auth()->user()->deal_percent }} %)</span></th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링전환</th>
									@if (auth()->user()->isInoutPartner())
									<th class="text-xs font-weight-bolder opacity-7 px-2">총정산금</th>
									@else
									<th class="text-xs font-weight-bolder opacity-7 px-2">총정산금 <span class="text-success">({{ auth()->user()->hasRole('manager') ? auth()->user()->shop->ggr_percent : auth()->user()->ggr_percent}} %)</span></th>
									@endif
								</tr>
							</thead>
							<tbody>
							<?php
								$totalggr = 0;
							?>
							@if (count($summary))
								@foreach ($summary as $adjustment)
									<?php
										$ggr = 0;
										$comaster = $adjustment->user;
										while ($comaster && !$comaster->hasRole('comaster'))
										{
											$comaster = $comaster->referral;
										}
										if ($comaster)
										{
											$ggr = ($adjustment->totalbet - $adjustment->totalwin) * $comaster->money_percent / 100;
										}
										$totalggr = $totalggr + $ggr;
									?>
									@include('backend.White.adjustment.partials.row_daily', ['ggr' => $ggr])
								@endforeach
								<tr>
								<td><span class='text-danger'></span></td>
								<td><span class='text-danger'>합계</span></td>
								<td><span class='text-danger'>{{number_format($summary->sum('totalin'),0)}}</span></td>
								<td><span class='text-danger'>{{number_format($summary->sum('totalout'),0)}}</span></td>
								<td><span class='text-danger'>{{number_format($summary->sum('totalbet'),0)}}</span></td>
								<td><span class='text-danger'>{{number_format($summary->sum('totalwin'),0)}}</span></td>

								<td><span class='text-success'>{{ number_format($summary->sum('total_deal')- $summary->sum('total_mileage'),0) }}</span></td>
								<td><span class='text-danger'>{{number_format($summary->sum('dealout'),0)}}</span></td>

								@if ( auth()->user()->hasRole('admin') || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
								<td><span class='text-success'>{{ number_format($summary->sum('total_ggr')- $summary->sum('total_ggr_mileage')-($summary->sum('total_deal')- $summary->sum('total_mileage')),0) }}</span></td>
								@else
								<td></td>
								@endif

								</tr>
							@else
								<tr><td colspan="12">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $summary->appends(Request::except('page'))->links() }}
				</div>	
			</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script>
		$(function() {
			$('input[name="dates"]').daterangepicker({
				timePicker: false,
				timePicker24Hour: false,
				startDate: moment().subtract(1, 'day'),
				endDate: moment().add(0, 'day'),

				locale: {
					format: 'YYYY-MM{{$type=="daily"?"-DD":""}}'
				}
			});
			$('input[name="dates"]').data('daterangepicker').setStartDate("{{$start_date}}");
			$('input[name="dates"]').data('daterangepicker').setEndDate("{{ $end_date }}");
		});
	</script>
@endpush