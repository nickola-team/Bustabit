@extends('backend.White.layouts.app')

@section('page-title', '자체게임')
@section('page-heading', '자체게임')

@push('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
@endpush
	
@section('content')
	
	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="row mt-4" id="toggle-box">
		<div class="col-12">
			<div class="card">
			<div class="card-header py-2 px-3">
				<h5>@lang('app.filter')</h5>
			</div>
			<div class="card-body py-2 px-3">
				<form action="" id="games-form" method="GET">
				<div class="row">
					<div class="col-6">
					<div class="input-group input-group-static">
						<label>게임이름</label>
						<input type="text" class="form-control" name="search" value="{{ Request::get('search') }}">
					</div>
					</div>
					<div class="col-6">
					<div class="input-group input-group-static">
						<label>@lang('app.status')</label>
						<?php
							$views = [
										'' => '모두', 
										'1' => '활성', 
										'0' => '비활성'
									];
						?>
						{!! Form::select('view', $views, Request::get('view'), ['id' => 'view', 'class' => 'form-control']) !!}
					</div>
					</div>
				</div>
				<div class="row mt-2">
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label>매장</label>
							<input type="text" class="form-control" name="shop" value="{{ Request::get('shop') }}" placeholder="매장이름">
						</div>
					</div> -->
					<div class="col-6">
					<div class="">
						<label>@lang('app.category')</label>
						<select class="form-control selectpicker" name="category[]" id="category" multiple="multiple" style="width: 100%;" data-placeholder="">
							<option value=""></option>
							@foreach ($categories as $key=>$category)
								<option value="{{ $category->id }}" {{ (count($savedCategory) && in_array($category->id, $savedCategory))? 'selected="selected"' : '' }}>{{ $category->title }}</option>
								@foreach ($category->inner as $inner)
									<option value="{{ $inner->id }}" {{ (count($savedCategory) && in_array($inner->id, $savedCategory))? 'selected="selected"' : '' }}>&nbsp;&nbsp;&nbsp;{{ $inner->title }}</option>
								@endforeach
							@endforeach
						</select>
					</div>
					</div>
				</div>
				<button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-3 mb-0">@lang('app.filter')</button>
				<a href="?clear" class="btn bg-gradient-dark btn-sm float-end mt-3 mb-0 mx-2">@lang('app.clear')</a>
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
							<th class="text-sm font-weight-bolder opacity-7 px-2">게임이름</th>
							<!-- <th class="text-sm font-weight-bolder opacity-7 px-2">베팅금</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">당첨금</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">벳윈</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">베팅횟수</th> -->
							<th class="text-sm font-weight-bolder opacity-7 px-2">상태</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2"></th>
						</tr>
					</thead>
					<tbody>
						@if (count($games))
							@foreach ($games as $game)
								@include('backend.White.games.partials.row')
							@endforeach
						@else
							<tr><td colspan="6">@lang('app.no_data')</td></tr>
						@endif
					</tbody>
					</table>
					{{ $games->appends(Request::except('page'))->links() }}
				</div>
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

	<script>
		$( document ).ready(function() {
			$('.selectpicker').selectpicker();
		});
				
		$('.openAdd').click(function(event){
			var type = $(event.target).data('type');
			$('.openAddClear').attr('href', '{{ route('backend.game.gamebanks_clear') }}?type=' + type);
			$('#gamebank_add').attr('action', '{{ route('backend.game.gamebanks_add') }}?type=' + type)
		});
		$('.changeAddSum').click(function(event){
			$v = Number($('#AddSum').val());
			$('#AddSum').val($v + $(event.target).data('value'));
		});

		$("#filter").detach().appendTo("div.toolbar");

		$("#view").change(function () {
			$("#games-form").submit();
		});
		$("#category").change(function () {
			$("#games-form").submit();
		});

		$('.checkAll').on('ifChecked', function(event){
			$('.minimal').iCheck('check');
		});

		$('.checkAll').on('ifUnchecked\t', function(event){
			$('.minimal').iCheck('uncheck');
		});

		$('.checkAll').click(function(event){
			if($(event.target).is(':checked') ){
				$('input[type=checkbox]').attr('checked', true);
			}else{
				$('input[type=checkbox]').attr('checked', false);
			}
		});


		// $("#shop_id").change(function () {
		// 	$("#change-shop-form").submit();
		// });

	</script>
@endpush