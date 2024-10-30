@extends('backend.White.layouts.app')

@section('page-title', trans('app.categories'))
@section('page-heading', trans('app.categories'))

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
					<h4 class="card-title ">@lang('app.categories')</h4>
					@permission('categories.add')
					<div class="pull-right box-tools">
						<a href="{{ route('backend.category.create') }}" class="btn btn-block btn-primary btn-sm">@lang('app.add')</a>
					</div>
					@endpermission
				</div>
				<div class="card-body table-hover">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
							<tr>
								<th>@lang('app.name')</th>
								<th>표시순서</th>
								<th>링크</th>
								<th>갯수</th>
							</tr>
							</thead>
							<tbody>
							@if (count($categories))
								@foreach ($categories as $category)
									@include('backend.White.categories.partials.row', ['base' => true])
									@foreach ($category->inner as $category)
										@include('backend.White.categories.partials.row', ['base' => false])
									@endforeach
								@endforeach
							@else
								<tr><td colspan="4">@lang('app.no_data')</td></tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop

@section('scripts')
	<script>
		$("#view").change(function () {
			$("#users-form").submit();
		});
		$("#shop_id").change(function () {
			$("#change-shop-form").submit();
		});
	</script>
@stop