@extends('backend.White.layouts.app')

@section('page-title', '게임뱅크충환전내역')
@section('page-heading', '게임뱅크충환전내역')

@section('content')

	<section class="content-header">
		@include('backend.White.partials.messages')
	</section>

	<section class="content">
		<div class="container-fluid">

			<form action="" method="GET">
				<div class="card">
					<div class="card-header card-header-icon card-header-primary">
						<h4 class="card-title ">@lang('app.filter')</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>@lang('app.name')</label>
									<input type="text" class="form-control" name="name" value="{{ Request::get('name') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>충/환전</label>
									{!! Form::select('type', ['' => 'All', 'add' => 'Add', 'out' => 'Out'], Request::get('type'), ['id' => 'type', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>최소충환전금</label>
									<input type="text" class="form-control" name="sum_from" value="{{ Request::get('sum_from') }}">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>최대충환전금</label>
									<input type="text" class="form-control" name="sum_to" value="{{ Request::get('sum_to') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>기간</label>
									<input type="text" class="form-control" name="dates" value="{{ Request::get('dates') }}">
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-primary">
							@lang('app.filter')
						</button>
					</div>
				</div>
			</form>

			<div class="card">
				<div class="card-header card-header-icon card-header-primary">
					<div class="card-icon">
						<i class="material-icons">assignment</i>
					</div>
					<h4 class="card-title ">게임뱅크충환전내역</h4>
				</div>
				<div class="card-body table-hover">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>@lang('app.name')</th>
								<th>이전포인트</th>
								<th>이후포인트</th>
								<th>충전금액</th>
								<th>환전금액</th>
								<th>시간</th>
							</tr>
							</thead>
							<tbody>
							@if (count($bank_stat))
								@foreach ($bank_stat as $stat)
									@include('backend.White.stat.partials.row_bank_stat')
								@endforeach
							@else
								<tr><td colspan="6">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $bank_stat->appends(Request::except('page'))->links() }}
				</div>			
			</div>
		</div>
	</section>

@stop

@section('scripts')
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

			$('.btn-box-tool').click(function(event){
				if( $('.bank_stat_show').hasClass('collapsed-box') ){
					$.cookie('bank_stat_show', '1');
				} else {
					$.removeCookie('bank_stat_show');
				}
			});

			if( $.cookie('bank_stat_show') ){
				$('.bank_stat_show').removeClass('collapsed-box');
			}
		});
	</script>
@stop