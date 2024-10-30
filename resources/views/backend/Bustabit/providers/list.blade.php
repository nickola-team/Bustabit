@extends('backend.White.layouts.app')

@section('page-title', '기본게임')
@section('page-heading', '기본게임')

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
                                            $status = [
                                                        '' => '모두', 
                                                        '0' => '활성', 
                                                        '1' => '비활성'
                                                    ];
                                        ?>
                                        {!! Form::select('limit', $status, Request::get('limit'), ['id' => 'limit', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="input-group input-group-static">
                                        <label>@lang('app.category')</label>
                                        <select id="category" class="form-control" name="category">
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->game_code }}" {{ $category->game_code == Request::get('category') ? 'selected' : ''}}> {{ $category->trans_kr }} </option>
                                            @endforeach
                                        </select>
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
							<th class="text-sm font-weight-bolder opacity-7 px-2">게임이름</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">상태</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2"></th>
						</tr>
					</thead>
					<tbody>
                        @if (count($games))
							@foreach ($games as $game)
                            <tr>
                                <td>
                                    <p class="ps-1 text-sm font-weight-bold mb-0">{{ $game['name_kr'] }}</p>
                                </td>
                                
                                <td>
                                    @if(in_array($game['uuid'], $limits))
                                        <span class="badge badge-sm bg-secondary">비활성</span>
                                    @else
                                        <span class="badge badge-sm bg-info">활성</span>
                                    @endif	
                                </td>
                                <td>
                                    @if(in_array($game['uuid'], $limits))
                                        <a href="{{ route('backend.provider.show', $game['uuid']) . '?limit=0' }}"
                                            class="btn bg-gradient-success btn-sm mb-0"
                                            data-method="PUT"
                                            data-confirm-title="경고"
                                            data-confirm-text="{{ $game['name_kr'] }} 게임을 활성화 하시겠습니까?"
                                            data-confirm-delete="확인">
                                                활성
                                        </a>
                                    @else
                                        <a href="{{route('backend.provider.show', $game['uuid']) . '?limit=1'}}"
                                            class="btn bg-gradient-warning btn-sm mb-0"
                                            data-method="PUT"
                                            data-confirm-title="경고"
                                            data-confirm-text="{{ $game['name_kr'] }} 게임을 비활성화 하시겠습니까?"
                                            data-confirm-delete="확인">
                                                비활성
                                        </a>
                                    @endif	
                                </td>
                            </tr>
							@endforeach
						@else
							<tr><td colspan="3">@lang('app.no_data')</td></tr>
						@endif
					</tbody>
					</table>
				</div>
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script> -->

	<script>
		// $( document ).ready(function() {
		// 	$('.selectpicker').selectpicker();
		// });
				
		// $('.openAdd').click(function(event){
		// 	var type = $(event.target).data('type');
		// 	$('.openAddClear').attr('href', '{{ route('backend.game.gamebanks_clear') }}?type=' + type);
		// 	$('#gamebank_add').attr('action', '{{ route('backend.game.gamebanks_add') }}?type=' + type)
		// });
		// $('.changeAddSum').click(function(event){
		// 	$v = Number($('#AddSum').val());
		// 	$('#AddSum').val($v + $(event.target).data('value'));
		// });

		// $("#filter").detach().appendTo("div.toolbar");

		$("#view").change(function () {
			$("#games-form").submit();
		});
		$("#category").change(function () {
			$("#games-form").submit();
		});

		// $('.checkAll').on('ifChecked', function(event){
		// 	$('.minimal').iCheck('check');
		// });

		// $('.checkAll').on('ifUnchecked\t', function(event){
		// 	$('.minimal').iCheck('uncheck');
		// });

		// $('.checkAll').click(function(event){
		// 	if($(event.target).is(':checked') ){
		// 		$('input[type=checkbox]').attr('checked', true);
		// 	}else{
		// 		$('input[type=checkbox]').attr('checked', false);
		// 	}
		// });


		// $("#shop_id").change(function () {
		// 	$("#change-shop-form").submit();
		// });

	</script>
@endpush