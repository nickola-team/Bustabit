@extends('backend.White.layouts.app')

@section('page-title', '충환전내역')
@section('page-heading', '충환전내역')

@section('content')

	<section class="content-header">
		@include('backend.White.partials.messages')
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-primary card-header-icon">
							<div class="card-icon">
								<i class="material-icons">equalizer</i>
							</div>
							<p class="card-category">총 충전금액</p>
							<h3 class="card-title">{{ number_format($stat['add']) }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
							<i class="material-icons">date_range</i> 방금전
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-primary card-header-icon">
							<div class="card-icon">
								<i class="material-icons">equalizer</i>
							</div>
							<p class="card-category">총 환전금액</p>
							<h3 class="card-title">{{ number_format($stat['out']) }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
							<i class="material-icons">date_range</i> 방금전
							</div>
						</div>
					</div>
				</div>
			</div>


			<form action="" method="GET">
				<div class="card">
					<div class="card-header card-header-icon card-header-primary">
						<h4 class="card-title ">@lang('app.filter')</h4>
					</div>
					<div class="card-body">
						<div class="row">
							@if (auth()->user()->isInoutPartner())
							<div class="col-md-6">
								<div class="form-group">
									<label>파트너이름</label>
									<input type="text" class="form-control" name="search" value="{{ Request::get('search') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>파트너타입</label>
									{!! Form::select('partner_type', ['partner' => '파트너', 'shop' => '매장'], Request::get('partner_type'), ['id' => 'partner_type', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>예금주</label>
									<input type="text" class="form-control" name="recommender" value="{{ Request::get('recommender') }}">
								</div>
							</div>
							@endif
							<div class="col-md-6">
								<div class="form-group">
									<label>충/환전</label>
									{!! Form::select('type', ['' => '모두', 'add' => '충전', 'out' => '환전'], Request::get('type'), ['id' => 'type', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>최소충환전금</label>
									<input type="text" class="form-control" name="sum_from" value="{{ Request::get('sum_from') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>최대충환전금</label>
									<input type="text" class="form-control" name="sum_to" value="{{ Request::get('sum_to') }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>신청기간</label>
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
					<h4 class="card-title ">충환전내역</h4>
				</div>
				<div class="card-body table-hover">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>파트너이름</th>
								@if (auth()->user()->isInoutPartner())
								@if (auth()->user()->hasRole(['admin','comaster','master','agent']))
								<th>{{\VanguardLTE\Role::where('slug','distributor')->first()->description}}</th>
								@endif
								@if (auth()->user()->hasRole(['admin','comaster','master']))
								<th>{{\VanguardLTE\Role::where('slug','agent')->first()->description}}</th>
								@endif
								@if (auth()->user()->hasRole(['admin','comaster']))
								<th>{{\VanguardLTE\Role::where('slug','master')->first()->description}}</th>
								@endif
								@endif
								<th>충전금액</th>
								<th>환전금액</th>
								<th>이전포인트</th>
								<th>이후포인트</th>
								<th>계좌번호</th>
								<th>예금주</th>
								<th>신청시간</th>
								<th>처리시간</th>
								<th>상태</th>
							</tr>
							</thead>
							<tbody>
							@if (count($in_out_logs))
								@foreach ($in_out_logs as $in_out_log)
									@include('backend.White.adjustment.partials.row_in_out_log')
								@endforeach
							@else
								<tr><td colspan="13">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
	                    </table>
                    </div>
					{{ $in_out_logs->appends(Request::except('page'))->links() }}
				</div>
			</div>
		</div>
	</section>

@stop

@section('scripts')
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
@stop