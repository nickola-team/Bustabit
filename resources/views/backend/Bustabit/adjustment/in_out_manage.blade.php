@extends('backend.White.layouts.app')

@section('page-title', $type=='add'?'충전관리':'환전관리')
@section('page-heading', $type=='add'?'충전관리':'환전관리')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title ">{{$type=='add'?'충전':'환전'}}신청 ({{count($in_out_request)}}건)</h4>
					</div>
					<div class="card-body">
						@if (auth()->user()->hasRole(['admin', 'comaster', 'master']))
						<div class="d-flex">
							<div class="form-check ms-auto">
								<input type="checkbox" class="form-check-input" id="ratingOn" {{auth()->user()->rating > 0 ? 'checked' : ''}}>
								<label class="custom-control-label" for="ratingOn">알림음 ON/OFF</label>
							</div>
						</div>
						@endif

						@if (auth()->user()->hasRole('admin'))
							<div class="row">
								<div class="col-3">
									<div class="input-group input-group-static">
										<b>은행이름:</b> 
										@php
											$banks = array_combine(\VanguardLTE\User::$values['banks'], \VanguardLTE\User::$values['banks']);
										@endphp
										{!! Form::select('bank_name', $banks, auth()->user()->bank_name ? auth()->user()->bank_name : '', ['class' => 'form-control', 'id' => 'bank_name']) !!}		
									</div>
								</div>
								<div class="col-3">
									<div class="input-group input-group-static">
										<b>계좌번호:</b> 
										<input class="form-control" id="account_no" name="account_no" value="{{ auth()->user()->account_no ? auth()->user()->account_no : '' }}">
									</div>
								</div>
								<div class="col-3">
									<div class="input-group input-group-static">
										<b>예금주:</b> 
										<input class="form-control" id="recommender" name="recommender" value="{{ auth()->user()->recommender ? auth()->user()->recommender : '' }}">
									</div>
								</div>
								<div class="col-3 d-flex">
									<button class="btn bg-gradient-info mb-0 ms-auto" id="change-bank-account-btn" onclick="change_bank_account_info();" style="margin-left: 30px;">
										계좌정보변경
									</button>
								</div>
							</div>
						@endif

						<div class="table-responsive mt-4">
							<table class="table align-items-center mb-0">
								<thead>
									<tr>
										@if(auth()->user()->hasRole('distributor'))
										<th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
										@else
										<th class="text-xs font-weight-bolder opacity-7 px-2">파트너이름</th>
										@endif
										<th class="text-xs font-weight-bolder opacity-7 px-2">신청금액</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">계좌번호</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">예금주</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">시간</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">상태</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if (count($in_out_request))
										@foreach ($in_out_request as $in_out_log)
											@include('backend.White.adjustment.partials.row_in_out')
										@endforeach
									@else
										<tr><td colspan="7">@lang('app.no_data')</td></tr>
									@endif
								</tbody>
							</table>
							{{ $in_out_request->appends(Request::except('page'))->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title ">신청대기 ({{count($in_out_wait)}}건)</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table align-items-center mb-0">
								<thead>
								<tr>
									@if(auth()->user()->hasRole('distributor'))
									<th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
									@else
									<th class="text-xs font-weight-bolder opacity-7 px-2">파트너이름</th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">신청금액</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">계좌번호</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">예금주</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">시간</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">상태</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								@if (count($in_out_wait))
									@foreach ($in_out_wait as $in_out_log)
										@include('backend.White.adjustment.partials.row_in_out')
									@endforeach
								@else
									<tr><td colspan="8">@lang('app.no_data')</td></tr>
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title ">최근 {{$type=='add'?'충전':'환전'}}내역</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table align-items-center mb-0">
								<thead>
									<tr>
										<th class="text-xs font-weight-bolder opacity-7 px-2">파트너이름</th>
										@if (auth()->user()->isInoutPartner())
										@if (auth()->user()->hasRole(['admin','comaster','master','agent']))
										<th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','distributor')->first()->description}}</th>
										@endif
										@if (auth()->user()->hasRole(['admin','comaster','master']))
										<th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','agent')->first()->description}}</th>
										@endif
										@if (auth()->user()->hasRole(['admin','comaster']))
										<th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','master')->first()->description}}</th>
										@endif
										@endif
										<th class="text-xs font-weight-bolder opacity-7 px-2">신청금액</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">이전포인트</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">이후포인트</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">계좌번호</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">예금주</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">신청시간</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">처리시간</th>
									</tr>
								</thead>
								<tbody>
									@if (count($in_out_logs))
										@foreach ($in_out_logs as $in_out_log)
											@include('backend.White.adjustment.partials.row_in_out_log')
										@endforeach
									@else
										<tr><td colspan="9">@lang('app.no_data')</td></tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="openAllowModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('frontend.api.allow_in_out') }}" method="POST" id="addForm">
					<div class="modal-header">
						<h4 class="modal-title">심사</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="OutSum">승인하시겠습니까</label>
							<input type="hidden" id="in_out_id" name="in_out_id">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">취소</button>
						<button type="submit" class="btn btn-success" id="btnAddSum">확인</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="openRejectModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('frontend.api.reject_in_out') }}" method="POST" id="outForm">
					<div class="modal-header">
						<h4 class="modal-title">심사</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="OutSum">취소하시겠습니까</label>
							<input type="hidden" id="out_id" name="out_id">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">취소</button>
						<button type="submit" class="btn btn-success" id="btnOutSum">확인</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">파트너정보</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-3">
							<div class="form-group">
								파트너구조
							</div>		
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<span id='hierarchytxt'></span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-bs-dismiss="modal">확인</button>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('js')
	<script>
		$('.allowPayment').click(function(event){
			if( $(event.target).is('.newPayment') ){
				var id = $(event.target).attr('data-id');
			}else{
				var id = $(event.target).parents('.newPayment').attr('data-id');
			}
			$('#in_out_id').val(id);

		});

		$('.rejectPayment').click(function(event){
			if( $(event.target).is('.newPayment') ){
				var id = $(event.target).attr('data-id');
			}else{
				var id = $(event.target).parents('.newPayment').attr('data-id');
			}
			$('#out_id').val(id);
		});


		$('.partnerInfo').click(function(event){
			var info = $(event.target).attr('data-id');
			$('#hierarchytxt').text(info);
		});
		

		$('#btnAddSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#addForm').submit();
		});
		$('#btnOutSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#outForm').submit();
		});

		$('#ratingOn').click(function (event) {
			var rating = 0;
			if($(this).is(":checked")){
				rating = 1;
			}
			$.ajax({
					url: "/api/inoutlist.json",
					type: "GET",
					data: {'rating': rating },
					dataType: 'json',
					success: function (data) {
                    }
				});
		});
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
	</script>
@endpush