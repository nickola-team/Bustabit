@extends('backend.White.layouts.app')

@section('page-title', '롤링정산')
@section('page-heading', '롤링정산')

@section('content')

	<section class="content-header">
		@include('backend.White.partials.messages')
	</section>

	<section class="content">
		
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">롤링정산</h3>
				@if($user != null)
					<a href="{{ route('backend.adjustment_shift', $user->id==auth()->user()->id?'':'parent='.$user->parent_id) }}">
						{{$user->username}}
					</a>
				@endif
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>이름</th>
						<th>정산시작시간</th>
						<th>정산마감시간</th>
						<th>이월된 보유금</th>
						<th>충전</th>
						<th>환전</th>
						<th>하위충전</th>
						<th>하위환전</th>
						@if(auth()->user()->hasRole('manager') || (($user != null) && ($user->hasRole('distributor'))))
						<th>회원보유금</th>
						@endif
						<th>롤링수익</th>
						<th>마일리지</th>
						<th>롤링전환</th>
						<th>최종수익</th>
						<th>현재보유금</th>
						<th>정산</th>
					</tr>
					</thead>
					<tbody>
					@if (count($adjustments))
						@foreach ($adjustments as $adjustment)
							@include('backend.White.adjustment.partials.row_shift')
						@endforeach
					@else
						<tr><td colspan="14">@lang('app.no_data')</td></tr>
					@endif
					{{-- @if (count($shift_logs))
						@foreach ($shift_logs as $shift_log)
							@include('backend.White.adjustment.partials.row_shift_log')
						@endforeach
					@endif --}}
					</tbody>
					
					</table>
				</div>
				{{-- {{ $statistics->appends(Request::except('page'))->links() }} --}}
			</div>	
		</div>

		<div class="box box-primary">
			<div class="box-header">
			<h4 class="box-title">정산내역</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>이름</th>
						<th>정산시작시간</th>
						<th>정산마감시간</th>
						<th>이월된 보유금</th>
						<th>충전</th>
						<th>환전</th>
						<th>하위충전</th>
						<th>하위환전</th>
						<th>롤링수익</th>
						<th>마일리지</th>
						<th>롤링전환</th>
						<th>최종수익</th>
						<th>보유금</th>
						<th>정산금</th>
					</tr>
					</thead>
					<tbody>
					@if (count($shift_logs))
						@foreach ($shift_logs as $shift_log)
							@include('backend.White.adjustment.partials.row_shift_log')
						@endforeach
					@else
						<tr><td colspan="14">@lang('app.no_data')</td></tr>
					@endif
					</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</section>


	<div class="modal fade" id="openOutModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('backend.adjustment_shift_stat') }}" method="GET" id="outForm">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">정산</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="OutSum">환전금액</label>
							<input type="text" class="form-control" id="OutSum" name="summ" placeholder="환전금액"   required autofocus>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
						<div class="form-group">
							<label for="DealSum">롤링전환</label>
							<input type="text" class="form-control" id="DealSum" name="dealsumm" placeholder="전환금액"   required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('app.close')</button>
						<button type="button" class="btn btn-primary" onclick="adjustment_shift_stat();">확인</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@stop

@section('scripts')
	<script>
		$('#stat-table').dataTable();
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
				if( $('.pay_stat_show').hasClass('collapsed-box') ){
					$.cookie('pay_stat_show', '1');
				} else {
					$.removeCookie('pay_stat_show');
				}
			});

			if( $.cookie('pay_stat_show') ){
				$('.pay_stat_show').removeClass('collapsed-box');
				$('.pay_stat_show .btn-box-tool i').removeClass('fa-plus').addClass('fa-minus');
			}

			$('.outPayment').click(function(event){
				if( $(event.target).is('.newPayment') ){
					var id = $(event.target).attr('data-id');
					var id1 = $(event.target).attr('data-id1');
				}else{
					var id = $(event.target).parents('.newPayment').attr('data-id');
					var id1 = $(event.target).parents('.newPayment').attr('data-id1');
				}
				$('#OutSum').val(id);
				$('#DealSum').val(id1);
			});
		});

		function withdraw_balance(onsuccess) {
            var money = $('#OutSum').val();
            var _token = $('#_token').val();

            $.ajax({
                type: 'POST',
                url: '/api/withdraw',
                data: { money: money, _token: _token },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error) {
                        alert(data.msg);
                        return;
                    }
					else if (onsuccess)
					{
						onsuccess();
					}
                    
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function adjustment_shift_stat() {
            var _token = $('#_token').val();
			var _dealsum = $('#DealSum').val();
            $.ajax({
                type: 'POST',
                url: '/api/convert_deal_balance',
                data: { _token: _token, summ: _dealsum },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error && data.code != '000') {
                        alert(data.msg);
                        return;
                    }
					else {
						withdraw_balance( function(){
							$('#outForm').submit();
							});
					}
                    
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }
	</script>
@stop