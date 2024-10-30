@extends('backend.White.layouts.app')

@section('page-title', '자체게임정산')
@section('page-heading', '자체게임정산')

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
							<div class="col-md-3">
								<div class="input-group input-group-static">
									<label>분류</label>
									{!! Form::select('provider', ['all' => '모두', 'major' => 'GB슬롯', 'self' => '자체게임'], Request::get('provider'), ['id' => 'provider', 'class' => 'form-control']) !!}
								</div>
							</div>
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
				<div class="card card-body">
					<div class="table-responsive">
						<p class="text-sm font-weight-bold mb-0 float-end">업데이트 시간 {{$updated_at}}</p>
						<table class="table align-items-center mb-0">
							<thead>
							<tr>
								<th class="text-xs font-weight-bolder opacity-7 px-2">날짜</th>
								@if(Request::get('cat') == '')
								<th class="text-xs font-weight-bolder opacity-7 px-2">분류</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">게임사</th>
								@else
								<th class="text-xs font-weight-bolder opacity-7 px-2">게임이름</th>
								@endif
								<th class="text-xs font-weight-bolder opacity-7 px-2">베팅금</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">당첨금</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">베팅횟수</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">롤링수익</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">마일리지</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">최종수익</th>
							</tr>
							</thead>
							<tbody>
								@if (isset($categories))
									@foreach ($categories as $adjustment)
									<tr>
										<td rowspan="{{count($adjustment['cat'])}}"> 
											<p class="text-sm font-weight-normal mb-0">{{ $adjustment['date'] }}</p>
										</td>
										@include('backend.White.adjustment.partials.row_game', ['total' => false])
									</tr>

									@endforeach
								@endif
								<tr>
								<td > {{ $totalcategory['date'] }}</td>
								@include('backend.White.adjustment.partials.row_game', ['adjustment' => ['cat' => [$totalcategory]], 'total' => true])
								</tr>
							</tbody>
						</table>
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