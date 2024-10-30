@extends('backend.White.layouts.app')

<?php  
			$available_roles = Auth::user()->available_roles( true );
			$available_roles_trans = [];
			foreach ($available_roles as $key=>$role)
			{
				$role = \VanguardLTE\Role::find($key)->description;
				$available_roles_trans[$key] = $role;
			}
?>

@section('page-title', $available_roles_trans[$role_id] . '목록')
@section('page-heading', $available_roles_trans[$role_id] . '목록')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
			<div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
				<div class="card ">
					<div class="card-header p-3 pt-2 bg-transparent">
						<div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
							<i class="material-icons opacity-10">person_add</i>
						</div>
						<div class="text-end pt-1">
							<p class="text-sm mb-0 text-capitalize ">전체 {{$available_roles_trans[$role_id]}}수</p>
							<h4 class="mb-0 ">{{ $stat['count'] }}</h4>
						</div>
					</div>
					<hr class="horizontal my-0 dark">
					<div class="card-footer p-3">
						<p class="mb-0 ">방금전</p>
					</div>
				</div>
			</div>
		
			<div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
				<div class="card ">
					<div class="card-header p-3 pt-2 bg-transparent">
						<div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
							<i class="material-icons opacity-10">person_add</i>
						</div>
						<div class="text-end pt-1">
							<p class="text-sm mb-0 text-capitalize ">@lang('app.total_credit')</p>
							<h4 class="mb-0 ">{{ number_format($stat['sum']) }}</h4>
						</div>
					</div>
					<hr class="horizontal my-0 dark">
					<div class="card-footer p-3">
						<p class="mb-0 ">방금전</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4" id="toggle-box">
			<div class="col-12">
				<div class="card">
					<div class="card-header py-2 px-3">
						<h5>@lang('app.filter')</h5>
					</div>
					<div class="card-body py-2 px-3">
						<form action="" method="GET" id="users-form" >
							<div class="row">
								<div class="col-6">
									<div class="input-group input-group-static">
										<label>파트너이름</label>
										<input type="text" class="form-control" name="search" value="{{ Request::get('search') }}">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-6">
									<div class="input-group input-group-static">
										<label>최소보유금액</label>
										<input type="text" class="form-control" name="credit_from" value="{{ Request::get('credit_from') }}">
									</div>
								</div>
								<div class="col-6">
									<div class="input-group input-group-static">
									<label>최대보유금액</label>
										<input type="text" class="form-control" name="credit_to" value="{{ Request::get('credit_to') }}">
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
						<table class="table align-items-center mb-0">
							<thead>
								<tr>
									<th class="text-xs font-weight-bolder opacity-7 px-2">이름</th>
									<?php
										for ($r=$role_id+1;$r<auth()->user()->role_id;$r++)
										{
											echo '<th class="text-xs font-weight-bolder opacity-7 px-2">'.$available_roles_trans[$r].'</th>';
										}
									?>
									<th class="text-xs font-weight-bolder opacity-7 px-2">보유금</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링수익</th>
									@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
									<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈수익</th>
									@endif
									<th class="text-xs font-weight-bolder opacity-7 px-2">롤링%</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">라이브롤링%</th>
									@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
									<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈%</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">정산기간</th>
									<th class="text-xs font-weight-bolder opacity-7 px-2">다음정산시간</th>
									@endif
									@if ($role_id==7)
									<!-- <th class="text-xs font-weight-bolder opacity-7 px-2">머니퍼센트</th> -->
									@endif
									@if ($role_id==6)
									<th class="text-xs font-weight-bolder opacity-7 px-2">수익금리셋</th>
									@endif
									<th></th>
								</tr>
							</thead>
							<tbody>
								@if (count($partners))
									@foreach ($partners as $partner)
										@if ($partner['role_id'] > 2)
										<tr>
											@include('backend.White.user.partials.row_partner', ['user' => $partner])
										</tr>
										@endif
									@endforeach
								@else
									<tr><td colspan="6">@lang('app.no_data')</td></tr>
								@endif
							</tbody>
						</table>
						{{ $partners->appends(Request::except('page'))->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="openAddModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
			<div class="card card-plain">
				<div class="card-header pb-0 text-left">
				<h5 class=""><span id="in-user"></span> @lang('app.pay_in')</h5>
				</div>
				<div class="card-body pb-3">
				<form role="form text-left" action="{{ route('backend.user.balance.update') }}" method="POST"  id="addForm">
					<div class="input-group input-group-outline my-3">
					<label class="form-label">충전금액</label>
					<input type="text" class="form-control" id="AddSum" name="summ">
					<input type="hidden" name="type" value="add">
					<input type="hidden" id="AddId" name="user_id">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>

					<div class="form-group">
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="10000">10,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="20000">20,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="30000">30,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="50000">50,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="100000">100,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="200000">200,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeAddSum" data-value="300000">300,000</button>
					<button type="button" class="btn btn-sm bg-gradient-warning changeAddSum" data-value="0">초기화</button>
					</div>
				</form>
				</div>
			</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
			<button type="submit" class="btn bg-gradient-primary" id='btnAddSum'>확인</button>
			</div>
		</div>
		</div>
	</div>

	<div class="modal fade" id="openOutModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
			<div class="card card-plain">
				<div class="card-header pb-0 text-left">
				<h5 class=""><span id="out-user"></span> @lang('app.pay_out')</h5>
				</div>
				<div class="card-body pb-3">
				<form role="form text-left" action="{{ route('backend.user.balance.update') }}" method="POST"  id="outForm">
					<p for="OutSum">환전가능한 금액: <span id="available-point" class="text-info"></span></p>

					<div class="input-group input-group-outline my-3">
					<label class="form-label">환전금액</label>
					<input type="text" class="form-control" id="OutSum" name="summ">
					<input type="hidden" name="type" value="out">
					<input type="hidden" id="outAll" name="all" value="0">
					<input type="hidden" id="OutId" name="user_id">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>

					<div class="form-group">
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="10000">10,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="20000">20,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="30000">30,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="50000">50,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="100000">100,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="200000">200,000</button>
					<button type="button" class="btn btn-sm bg-gradient-info changeOutSum" data-value="300000">300,000</button>
					<button type="button" class="btn btn-sm bg-gradient-warning changeOutSum" data-value="0">초기화</button>
					</div>
				</form>
				</div>
			</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
			<button type="button" class="btn bg-gradient-danger" id="doOutAll">@lang('app.all') @lang('app.pay_out')</button>
			<button type="submit" class="btn bg-gradient-primary" id='btnOutSum'>확인</button>
			</div>
		</div>
		</div>
	</div>

	<div class="modal fade" id="openResetModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
			<div class="card card-plain">
				<div class="card-header pb-0 text-left">
					<h5 class=""><span id="reset-user"></span> 리셋</h5>
				</div>
				<div class="card-body pb-3">
				<form role="form text-left" action="{{ route('backend.user.partner.reset_ggr') }}" method="POST"  id="resetForm">
					<div class="input-group input-group-outline my-3">
						<p>정말 리셋하시겠습니까?</p>
						<input type="hidden" id="masterid" name="masterid">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
				</form>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
				<button type="submit" class="btn bg-gradient-primary" id='btnResetSum'>확인</button>
			</div>
		</div>
		</div>
	</div>
@endsection

@push('js')
	<script>

		$(function() {


		$('.allowReset').click(function(event){
			if( $(event.target).is('.newReset') ){
				var id = $(event.target).attr('data-id');
				var user = $(event.target).attr('data-user');
			}else{
				var id = $(event.target).parents('.newReset').attr('data-id');
				var user = $(event.target).parents('.newPayment').attr('data-user');
			}
			$('#masterid').val(id);
			$('#reset-user').text(user);
		});
		$('.addPayment').click(function(event){
			if( $(event.target).is('.newPayment') ){
				var id = $(event.target).attr('data-id');
				var user = $(event.target).attr('data-user');
			}else{
				var id = $(event.target).parents('.newPayment').attr('data-id');
				var user = $(event.target).parents('.newPayment').attr('data-user');
			}
			$('#AddId').val(id);
			$('#in-user').text(user);
		});
		$('.changeAddSum').click(function(event){
			$v = Number($('#AddSum').val());
			if ($(event.target).data('value') == 0)
			{
				$('#AddSum').val(0);
			}
			else
			{
				$('#AddSum').val($v + $(event.target).data('value'));
			}
			$('#AddSum').focus();
		});

		$('.changeOutSum').click(function(event){
			$v = Number($('#OutSum').val());
			if ($(event.target).data('value') == 0)
			{
				$('#OutSum').val(0);
			}
			else
			{
				$('#OutSum').val($v + $(event.target).data('value'));
			}
			$('#OutSum').focus();
		});

		$('.outPayment').click(function(event){
			if( $(event.target).is('.newPayment') ){
				var id = $(event.target).attr('data-id');
				var available = $(event.target).attr('data-available');
				var user = $(event.target).attr('data-user');
			}else{
				var id = $(event.target).parents('.newPayment').attr('data-id');
				var available = $(event.target).parents('.newPayment').attr('data-available');
				var user = $(event.target).parents('.newPayment').attr('data-user');
			}
			$('#OutId').val(id);
			$('#outAll').val('');
			$('#available-point').text(available);
			$('#out-user').text(user);
		});

		$('#btnAddSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#addForm').submit();
		});
		$('#btnResetSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#resetForm').submit();
		});
		$('#btnOutSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#outForm').submit();
		});

		$('#doOutAll').click(function () {
			$(this).attr('disabled', 'disabled');
			$('#outAll').val('1');
			$('form#outForm').submit();
		});
		});
	</script>
@endpush