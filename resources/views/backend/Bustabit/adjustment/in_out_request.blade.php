@extends('backend.White.layouts.app')

@section('page-title', '충환전신청')
@section('page-heading', '충환전신청')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="card card-body">
				<input type="hidden" value="<?= csrf_token() ?>" name="_token" id="_token">

				<div class="row">
					<div class="col-md-6">
						<b>입금 은행계좌 : </b>
						<button class="btn bg-gradient-primary btn-sm mb-0" id="togglebankinfo">
							보이기
						</button>
						<span class="text-info text-xs font-weight-bolder" id="bankinfo" style="display:none;">
							{{$bankinfo}}
						</span>
					</div>
				</div>

				<div class="row mt-3">
						<div class="col-md-3">
						<div class="input-group input-group-static">
						<b>본인 은행계좌:</b> 
							@php
								$banks = array_combine(\VanguardLTE\User::$values['banks'], \VanguardLTE\User::$values['banks']);
							@endphp
							{!! Form::select('bank_name', $banks, auth()->user()->bank_name ? auth()->user()->bank_name : '', ['class' => 'form-control', 'id' => 'bank_name']) !!}		
						</div>
					</div>

					<div class="col-md-3">
						<div class="input-group input-group-static">
							<b>계좌번호:</b> 
							<input class="form-control" id="account_no" name="account_no" value="{{ auth()->user()->account_no ? auth()->user()->account_no : '' }}">
						</div>
					</div>

					<div class="col-md-3">
						<div class="input-group input-group-static">
						<b>예금주:</b> 
						<input class="form-control" id="recommender" name="recommender" value="{{ auth()->user()->recommender ? auth()->user()->recommender : '' }}">
						</div>
					</div>

					<div class="col-md-3">
						<button class="btn bg-gradient-primary mb-0" id="change-bank-account-btn" onclick="change_bank_account_info();">
							계좌정보변경
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4" id="toggle-box">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title ">충환전신청</h4>
				</div>
				<div class="card-body pt-0">
					<div class="row">
						<?php
						$dealvalue = auth()->user()->hasRole('manager')?auth()->user()->shop->deal_balance:auth()->user()->deal_balance - auth()->user()->mileage;
						$balance = auth()->user()->hasRole('manager')?auth()->user()->shop->balance:auth()->user()->balance;
						?>
						@if(auth()->user()->hasRole(['agent','distributor','manager', 'master']))
						<div class="col-md-6">
							<p class="font-weight-bold mb-0">
								롤링수익: {{ number_format($dealvalue,0) }}원 &nbsp; <span class="font-weight-normal text-sm">(롤링: {{number_format(auth()->user()->hasRole('manager')?auth()->user()->shop->deal_percent:auth()->user()->deal_percent,2)}}%, 라이브롤링: {{number_format(auth()->user()->hasRole('manager')?auth()->user()->shop->table_deal_percent:auth()->user()->table_deal_percent,2)}}%) </span>								
							</p>
						</div>
						<div class="col-md-2">
							<a class="newPayment outPayment" href="#" data-bs-toggle="modal" data-bs-target="#openOutModal"  data-id="{{ (int)($dealvalue / 10000) * 10000 }}">
								<button class="btn bg-gradient-success btn-sm mb-0" id="convert-deal-balance-btn">롤링전환</button>
							</a>
						</div>
						@endif
					</div>

					<div class="row mt-2">
						<div class="col-md-3">
							<div class="input-group input-group-static">
								<b>신청금액:</b>
								<input type="number" class="form-control" style="background-color: unset;" id="withdraw_money" name="withdraw_money" value="" placeholder="신청금액을 입력하세요." readonly>
							</div>
						</div>
					</div>

					<div class="mt-2">
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-10k" onclick="add_money(10000);">
							+10,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-50k" onclick="add_money(50000);">
							+50,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-100k" onclick="add_money(100000);">
							+100,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-500k" onclick="add_money(500000);">
							+500,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-1m" onclick="add_money(1000000);">
							+1,000,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-3m" onclick="add_money(3000000);">
							+3,000,000
						</button>
						<button class="btn bg-gradient-info btn-sm mb-0" id="money-5m" onclick="add_money(5000000);">
							+5,000,000
						</button>
						<button class="btn bg-gradient-warning btn-sm mb-0" id="reset" onclick="reset_money();">
							초기화
						</button>
					</div>
				</div>
				<div class="card-footer d-flex pt-0">
					<button class="btn bg-gradient-danger btn-sm mb-0 ms-auto mx-2" id="withdraw-balance-btn" onclick="withdraw_balance();">
						환전신청
					</button>
					
					<button class="btn bg-gradient-success btn-sm mb-0" id="deposit-balance-btn" onclick="deposit_balance();" {{(auth()->user()->hasRole(['agent','distributor']) || (auth()->user()->hasRole('master') && settings('enable_master_deal')))?'disabled':''}}>
						충전신청
					</button>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title ">신청내역</h4>
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table align-items-center mb-0">
							<thead>
							<tr>
								@if(auth()->user()->hasRole('manager'))
								<th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
								@else
								<th class="text-xs font-weight-bolder opacity-7 px-2">파트너이름</th>
								@endif
								<th class="text-xs font-weight-bolder opacity-7 px-2">신청금액</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">계좌번호</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">예금주</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">신청시간</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">상태</th>
							</tr>
							</thead>
							<tbody>
							@if (count($in_out_logs))
								@foreach ($in_out_logs as $in_out_log)
									@include('backend.White.adjustment.partials.row_in_out')
								@endforeach
							@else
								<tr><td colspan="4">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $in_out_logs->appends(Request::except('page'))->links() }}
				</div>			
			</div> 
		</div>

		@if(auth()->user()->hasRole('manager'))
		<div class="row mt-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title ">롤링전환내역</h4>
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table align-items-center mb-0">
							<thead>
							<tr>
								<th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">파트너이름</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">이전포인트</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">이후포인트</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">롤링전환</th>
								<th class="text-xs font-weight-bolder opacity-7 px-2">시간</th>
							</tr>
							</thead>
							<tbody>
							@if (count($rolling_logs))
								@foreach ($rolling_logs as $rolling_log)
									@include('backend.White.adjustment.partials.row_rolling')
								@endforeach
							@else
								<tr><td colspan="6">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $rolling_logs->appends(Request::except('page'))->links() }}
				</div>			
			</div>
		</div> 
		@endif
	</div>

	<div class="modal fade" id="openOutModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="#" method="GET" id="outForm">
					<div class="modal-header">
						<h4 class="modal-title">정산</h4>
					</div>
					<div class="modal-body">
						<div class="input-group input-group-static">
							<label for="OutSum">롤링전환</label>
							<input type="text" class="form-control" id="OutSum" name="OutSum" placeholder="전환금액"   required>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn bg-gradient-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
						<button class="btn bg-gradient-success" onclick="convert_deal_balance();">확인</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('js')
	<script>
		$(function() {

			$('#togglebankinfo').click(function() {
				if($("#bankinfo").is(":visible")){
					$("#bankinfo").hide();
					$('#togglebankinfo').html('보이기');
				}
				else
				{
					$("#bankinfo").show();
					$('#togglebankinfo').html('숨기기');
				}
				
			});

			$('.outPayment').click(function(event){
				if( $(event.target).is('.newPayment') ){
					var id = $(event.target).attr('data-id');
				}else{
					var id = $(event.target).parents('.newPayment').attr('data-id');
				}
				$('#OutSum').val(id);
			});
		});


		function withdraw_balance() {
			$('#withdraw-balance-btn').attr('disabled', 'disabled');
            var money = $('#withdraw_money').val();
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
                        if (data.code == '001') {
                            location.reload(true);
                        }
                        else if (data.code == '002') {
                            $('#withdraw_money').focus();
                        }
                        else if (data.code == '003') {
                            $('#withdraw_money').val('0');
                        }
                        return;
                    }
                    alert('환전 신청이 완료되었습니다.');
                    location.reload(true);
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function deposit_balance() {
            var money = $('#withdraw_money').val();
            var _token = $('#_token').val();

            $.ajax({
                type: 'POST',
                url: '/api/deposit',
                data: { money: money, _token: _token },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error) {
                        alert(data.msg);
                        if (data.code == '001') {
                            location.reload(true);
                        }
                        else if (data.code == '002') {
                            $('#withdraw_money').focus();
                        }
                        else if (data.code == '003') {
                            $('#withdraw_money').val('0');
                        }
                        return;
                    }
                    alert('충전 신청이 완료되었습니다.');
                    location.reload(true);
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function withdraw_deal_balance() {
            var _token = $('#_token').val();
			var _dealsum = $('#OutSum').val();

            $.ajax({
                type: 'POST',
                url: '/api/deal_withdraw',
                data: { summ: _dealsum, _token: _token },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error) {
                        alert(data.msg);
						location.reload(true);
                        return;
                    }
                    alert('수익금환전 신청이 완료되었습니다.');
                    location.reload(true);
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function convert_deal_balance() {
            var _token = $('#_token').val();
			var _dealsum = $('#OutSum').val();

            $.ajax({
                type: 'POST',
                url: '/api/convert_deal_balance',
                data: { _token: _token, summ: _dealsum },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error) {
                        alert(data.msg);
                        return;
                    }
                    alert('수익금이 보유금으로 전환되었습니다.');
                    location.reload(true);
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function change_bank_account_info() {
            var bank_name = $('#bank_name').val();
			var account_no = $('#account_no').val();
			var recommender = $('#recommender').val();
            var _token = $('#_token').val();

            $.ajax({
                type: 'POST',
                url: '/api/change_bank_account',
                data: { bank_name: bank_name, account_no: account_no, recommender: recommender, _token: _token },
                cache: false,
                async: false,
                success: function (data) {
                    if (data.error) {
                        alert(data.msg);
                        return;
                    }
                    alert('입금 계좌가 변경되었습니다.');
                    location.reload(true);
                },
                error: function (err, xhr) {
                    alert(err.responseText);
                }
            });
        }

		function add_money(amount) {
			var withdraw_money = $('#withdraw_money').val();
			if(withdraw_money == ''){
				withdraw_money = 0;
			}
			withdraw_money = parseInt(withdraw_money) + amount;
			$('#withdraw_money').val(withdraw_money);
		}

		function reset_money() {
			$('#withdraw_money').val(0);
		}

	</script>
@endpush