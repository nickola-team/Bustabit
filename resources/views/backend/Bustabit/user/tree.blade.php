@extends('backend.White.layouts.app')

@section('page-title', '파트너구조')
@section('page-heading', '파트너구조')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
        <div class="row mt-4">
			<div class="col-12">
				<div class="card">
					<div class="card-header pb-0">
						<?php  
							$available_roles = \jeremykenedy\LaravelRoles\Models\Role::orderby('id')->pluck('name', 'id');
							$available_roles_trans = [];
							foreach ($available_roles as $key=>$role)
							{
								$role = \VanguardLTE\Role::find($key)->description;
								$available_roles_trans[$key] = $role;
							}
						?>
						<h4 class="card-title">파트너목록</h4>
						@if($user != null && !$user->hasRole('admin'))
							<a href="{{ route('backend.user.tree', $user->id==auth()->user()->id?'':'parent='.$user->parent_id) }}">
								{{$user->username}}
								[ {{$available_roles_trans[$user->role_id]}}]
							</a>
						@endif
					</div>
					<div class="card-body">
						<div class="table-responsive">
							@permission('users.add')
							@if (Auth::user()->hasRole(['admin','comaster','master', 'agent','distributor']))
							<div class="d-flex">
								<a href="{{ route('backend.user.create') }}" class="btn bg-gradient-primary ms-auto">파트너 @lang('app.add')</a>
							</div>
							@endif
							@endpermission
							<table class="table align-items-center mb-0">
								<thead>
									<tr>
										<th class="text-xs font-weight-bolder opacity-7 px-2">이름</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">등급</th>
										@if ( ($user!=null && $user->hasRole('distributor')) )
										<th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
										@endif
										<th class="text-xs font-weight-bolder opacity-7 px-2">보유금</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">롤링수익</th>
										@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
										<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈수익</th>
										@endif
										<th class="text-xs font-weight-bolder opacity-7 px-2">롤링%</th>
										<th class="text-xs font-weight-bolder opacity-7 px-2">라이브롤링%</th>
										@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
										<th class="text-xs font-weight-bolder opacity-7 px-2">벳윈%</th>
										<!-- <th class="text-xs font-weight-bolder opacity-7 px-2">정산기간</th> -->
										@endif
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if (count($partners))
										@foreach ($partners as $partner)
											@if ($partner['role_id'] > 2)
											<tr>
												@include('backend.White.user.partials.row_tree', ['user' => $partner])
											</tr>
											@endif
										@endforeach
									@else
										<tr><td colspan="5">@lang('app.no_data')</td></tr>
									@endif
								</tbody>
							</table>
						</div>
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

@endsection

@push('js')
	<script>

		$(function() {

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
				$('#AddSum').focus()
			}
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
			$('#available-point').text(available);
			$('#outAll').val('');
			$('#out-user').text(user);
		});

		$('#btnAddSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#addForm').submit();
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