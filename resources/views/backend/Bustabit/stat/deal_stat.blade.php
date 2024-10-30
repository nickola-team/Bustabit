@extends('backend.White.layouts.app')

@section('page-title', '롤링내역')
@section('page-heading', '롤링내역')

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
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>게임명</label>
										<input type="text" class="form-control" name="game" value="{{ Request::get('game') }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>회원이름</label>
										<input type="text" class="form-control" name="user" value="{{ Request::get('user') }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>최소베팅금액</label>
										<input type="text" class="form-control" name="bet_from" value="{{ Request::get('bet_from') }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>최대베팅금액</label>
										<input type="text" class="form-control" name="bet_to" value="{{ Request::get('bet_to') }}">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>기간</label>
										<input type="text" class="form-control" name="dates" value="{{ Request::get('dates') }}">
									</div>
								</div>
								@if (auth()->user()->isInoutPartner())
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>파트너이름</label>
										<input type="text" class="form-control" name="partner" value="{{ Request::get('partner') }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group input-group-static">
										<label>타입</label>
										{!! Form::select('type', ['partner' => '파트너', 'shop' => '매장'], Request::get('type'), ['id' => 'type', 'class' => 'form-control']) !!}
									</div>
								</div>
								@endif
							</div>
							<button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-3 mb-0">@lang('app.filter')</button>
							<!-- @if( Auth::user()->hasRole('admin') )
								<a href="{{ route('backend.game_stat.clear') }}"
								class="btn btn-danger"
								data-method="DELETE"
								data-confirm-title="경고"
								data-confirm-text="모든 게임로그를 삭제하시겠습니까?"
								data-confirm-delete="확인">
									롤링적립내역 삭제
								</a>
							@endif -->
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
								<th class="text-xs font-weight-normal opacity-7 px-2">게임사</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">게임명</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">회원이름</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">파트너(매장)</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">배팅금액</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">당첨금액</th>
								<th class="text-xs font-weight-normal opacity-7 px-2">롤링수익</th>
								@if (auth()->user()->hasRole('admin')  || (auth()->user()->hasRole(['master','agent', 'distributor']) && auth()->user()->ggr_percent > 0) 
									|| (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
								<th class="text-xs font-weight-normal opacity-7 px-2">벳윈수익</th>
								@endif
								<th class="text-xs font-weight-normal opacity-7 px-2">배팅시간</th>
							</tr>
							</thead>
							<tbody>
							@if (count($game_stat))
								@foreach ($game_stat as $stat)
									@include('backend.White.stat.partials.row_deal_stat')
								@endforeach
							@else
								<tr><td colspan="11">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $game_stat->appends(Request::except('page'))->links() }}
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