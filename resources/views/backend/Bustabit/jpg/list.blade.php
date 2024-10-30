@extends('backend.White.layouts.app')

@section('page-title', '잭팟관리')
@section('page-heading', '잭팟관리')

@section('content')

	<section class="content-header">
		@include('backend.White.partials.messages')
	</section>

	<section class="content">
		<div class="container-fluid">

			<form id="change-shop-form"  name = "set_shop" action="{{ route('backend.profile.setshop') }}" method="POST">
				<div class="card">
					<div class="card-header card-header-icon card-header-primary">
						<h4 class="card-title ">@lang('app.filter')</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>매장</label>
									{!! Form::select('shop_id',
										[0=>'기본매장']+Auth::user()->shops_array(), Auth::user()->shop_id, ['class' => 'form-control', 'style' => 'width: 100%;', 'id' => 'shop_id']) !!}
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="card">
				<div class="card-header card-header-icon card-header-primary">
					<div class="card-icon">
						<i class="material-icons">assignment</i>
					</div>
					<h4 class="card-title ">잭팟관리</h4>
				</div>
				<div class="card-body table-hover">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>아이디</th>
								<th>@lang('app.name')</th>
								<th>현재금액</th>
								<th>시작금액</th>
								<th>당첨금액(일반)</th>
								<th>당첨금액(VT)</th>
								<th>퍼센트</th>
								<th>@lang('app.status')</th>
								<th>@lang('app.pay_in')</th>
								<th>@lang('app.pay_out')</th>
							</tr>
							</thead>
							<tbody>
							@if (count($jackpots))
								@foreach ($jackpots as $jackpot)
									@include('backend.White.jpg.partials.row')
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
	</section>

	<!-- Modal -->
	<div class="modal fade" id="openAddModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('backend.jpgame.balance') }}" method="POST">
					<div class="modal-header">
						<h4 class="modal-title">@lang('app.balance') @lang('app.pay_in')</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="AddSum">@lang('app.sum')</label>
							<input type="text" class="form-control" id="AddSum" name="summ" placeholder="@lang('app.sum')" required>
							<input type="hidden" name="type" value="add">
							<input type="hidden" id="AddId" name="jackpot_id">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">@lang('app.close')</button>
						<button type="submit" class="btn btn-success">@lang('app.pay_in')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="openOutModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('backend.jpgame.balance') }}" method="POST" id="outForm">
					<div class="modal-header">
						<h4 class="modal-title">@lang('app.balance') @lang('app.pay_out')</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="OutSum">@lang('app.sum')</label>
							<input type="text" class="form-control" id="OutSum" name="summ" placeholder="@lang('app.sum')" required>
							<input type="hidden" id="outAll" name="all" value="0">
							<input type="hidden" name="type" value="out">
							<input type="hidden" id="OutId" name="jackpot_id">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">@lang('app.close')</button>
						<button type="button" class="btn btn-danger" id="doOutAll">@lang('app.pay_out') @lang('app.all')</button>
						<button type="submit" class="btn btn-primary">@lang('app.pay_out')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@stop

@section('scripts')
	<script>
		$("#status").change(function () {
			$("#users-form").submit();
		});
		$('.addPayment').click(function(event){
			console.log($(event.target));
			var item = $(event.target).hasClass('addPayment') ? $(event.target) : $(event.target).parent();
			var id = item.attr('data-id');
			$('#AddId').val(id);
			$('#outAll').val('0');
		});


		$('#doOutAll').click(function () {
			$('#outAll').val('1');
			$('form#outForm').submit();
		});

		$('.outPayment').click(function(event){
			console.log($(event.target));
			var item = $(event.target).hasClass('outPayment') ? $(event.target) : $(event.target).parent();
			console.log(item);
			var id = item.attr('data-id');
			$('#OutId').val(id);
		});

		$("#shop_id").change(function () {
			$("#change-shop-form").submit();
		});
	</script>
@stop