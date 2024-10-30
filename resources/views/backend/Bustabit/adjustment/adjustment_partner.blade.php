@extends('backend.White.layouts.app')

@section('page-title', '파트너별정산')
@section('page-heading', '파트너별정산')

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
						<a href="{{ route('backend.adjustment_partner', $user->id==auth()->user()->id?'':'parent='.$user->parent_id) }}">
							<h5 class="card-title">{{$user->username}} [ {{$available_roles_trans[$user->role_id]}} ]</h5>
						</a>
						@endif
					</div>
					<div class="card-body pt-0">
						<div class="table-responsive">
							<p class="text-sm font-weight-bold mb-0 float-end">업데이트 시간 {{$updated_at}}</p>
							<table class="table align-items-center mb-0">
								<thead>
								<tr>
									<th class="text-xs font-weight-bolder opacity-7 px-2">이름</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">등급</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">충전</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">환전</th>
									@if(auth()->user()->isInoutPartner())
									<th class="text-xs font-weight-bolder opacity-7 px-2">이익금</th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링수익</th>
									@if ( auth()->user()->hasRole('admin') || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
									<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈수익</th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링전환</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈</th>
									<!-- @if(auth()->user()->isInoutPartner())
									<th class="text-xs font-weight-bolder opacity-7 px-2">머니금액</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">순이익금</th>
									@endif		 -->
								</tr>
								</thead>
								<tbody>
									@if (count($adjustments))
										@foreach ($adjustments as $adjustment)
											@include('backend.White.adjustment.partials.row_partner')
										@endforeach
									@else
										<tr><td colspan="14">@lang('app.no_data')</td></tr>
									@endif
								</tbody>
							</table>
						</div>
						{{ $childs->appends(Request::except('page'))->links() }}
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
					format: 'YYYY-MM-DD'
				}
			});
			$('input[name="dates"]').data('daterangepicker').setStartDate("{{$start_date}}");
			$('input[name="dates"]').data('daterangepicker').setEndDate("{{ $end_date }}");
		});
	</script>
@endpush