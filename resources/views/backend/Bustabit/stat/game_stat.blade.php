@extends('backend.White.layouts.app')

@section('page-title', '게임베팅내역')
@section('page-heading', '게임베팅내역')

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
							<div class="col-md-6">
								<div class="input-group input-group-static">
									<label>게임명</label>
									<input class="form-control" name="game" value="{{ Request::get('game') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group input-group-static">
									<label>회원이름</label>
									<input class="form-control" name="user" value="{{ Request::get('user') }}">
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최소보유금액</label>
									<input class="form-control" name="balance_from" value="{{ Request::get('balance_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최대보유금액</label>
									<input class="form-control" name="balance_to" value="{{ Request::get('balance_to') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최소베팅금액</label>
									<input class="form-control" name="bet_from" value="{{ Request::get('bet_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최대베팅금액</label>
									<input class="form-control" name="bet_to" value="{{ Request::get('bet_to') }}">
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최소당첨금액</label>
									<input class="form-control" name="win_from" value="{{ Request::get('win_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>최대당첨금액</label>
									<input class="form-control" name="win_to" value="{{ Request::get('win_to') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group input-group-static">
									<label>기간</label>
									<input class="form-control" name="dates" value="{{ Request::get('dates') }}">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer d-flex">
						<button type="submit" class="btn bg-gradient-dark btn-sm mb-0 ms-auto">
							@lang('app.filter')
						</button>
						<!-- @if( Auth::user()->hasRole('admin') )
							<a href="{{ route('backend.game_stat.clear') }}"
							class="btn btn-sm bg-gradient-danger mb-0"
							data-method="DELETE"
							data-confirm-title="경고"
							data-confirm-text="모든 게임로그를 삭제하시겠습니까?"
							data-confirm-delete="확인">
								게임베팅내역 삭제
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
								<th class="text-xs font-weight-bolder opacity-7 px-2">게임사</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">게임명</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">아이디</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">보유금액</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금액</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금액</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">베팅시간</th>
							</tr>
							</thead>
							<tbody>
							@if (count($game_stat))
								@foreach ($game_stat as $stat)
									@include('backend.White.games.partials.row_stat')
								@endforeach
							@else
								<tr><td colspan="6">@lang('app.no_data')</td></tr>
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
			$('.getbalance').click(function(event)
			{
				var item = $(event.target);
				var id = item.attr('data-id');
				$.ajax({
					type: 'GET',
					url: "{{route('backend.game_stat.balance')}}?id=" + id,
					cache: false,
					async: false,
					success: function (data) {
						if (data['error'] == false)
						{
							$(event.target).removeClass('text-red').addClass('text-green');
							$(event.target).text(data['balance']);
						}
					},
					error: function (err, xhr) {
						console.log(err.responseText);
					},
				});
			});
		});
	</script>
@endpush