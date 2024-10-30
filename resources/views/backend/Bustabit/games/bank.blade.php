@extends('backend.White.layouts.app')

@section('page-title', '환수금관리')
@section('page-heading', '환수금관리')

@section('content')

	@include('backend.White.partials.messages')

	<div class="container-fluid py-4">
		<div class="card card-body mt-4">
			<div class="table-responsive">
				<table class="table align-items-center mb-0">
					<thead>
						<tr>
							<th class="text-sm font-weight-bolder opacity-7 px-2">게임</th>
							<!-- <th class="text-sm font-weight-bolder opacity-7 px-2">환수율%</th> -->
							<th class="text-sm font-weight-bolder opacity-7 px-2">환수금</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">
								<button class="btn bg-gradient-success btn-sm openAdd mb-0" data-bs-toggle="modal" data-bs-target="#openAddModal" data-type="slots" data-game="{{ 0 }}">일괄조절 
									<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
								</button>
							</th>
							<!-- <th class="text-sm font-weight-bolder opacity-7 px-2">테이블환수금 &nbsp;&nbsp;&nbsp; 
								<button type="button" class="btn btn-info btn-round btn-sm" data-toggle="modal" data-target="#openAddModal" data-type="table_bank" data-game="{{ 0 }}">
									일괄조절 
									<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
								</button>
							</th> -->
							<th class="text-sm font-weight-bolder opacity-7 px-2">보너스환수금</th>
							<th class="text-sm font-weight-bolder opacity-7 px-2">
								<button type="button" class="btn bg-gradient-success btn-sm openAdd mb-0" data-bs-toggle="modal" data-bs-target="#openAddModal" data-type="bonus" data-game="{{ 0 }}">
									일괄조절 
									<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
								</button>
							</th>
						</tr>
					</thead>
					<tbody>
						@if (count($gamebank))
							@foreach ($gamebank as $bank)
								@include('backend.White.games.partials.row_bank')
							@endforeach
						@else
							<tr><td colspan="4">@lang('app.no_data')</td></tr>
						@endif
					</tbody>
				</table>
				{{ $gamebank->appends(Request::except('page'))->links() }}
			</div>
		</div>
	</div>



	<div class="modal fade" id="openAddModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<form action="" method="POST" id="gamebank_add">
		<div class="modal-content">
			<div class="modal-body p-0">
			<div class="card card-plain">
				<div class="card-header pb-0 text-left">
					<h5 class="card-title">환수금조절</h5>
				</div>
				<div class="card-body pb-3">
					<div class="input-group input-group-outline my-3">
						<label class="form-label">충전금액</label>
						<input type="text" class="form-control" id="AddSum" name="summ" required>
						<!-- <input type="hidden" name="gameid" value=""> -->
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
					</div>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<a href="" class="btn bg-gradient-warning openAddClear mb-0">초기화</a>
				<button type="submit" class="btn bg-gradient-success mb-0">추가</a>
			</div>
		</div>
		</form>
		</div>
	</div>
@endsection

@push('js')
    <script>
		$('.openAdd').click(function(event){
			var type = $(event.target).data('type');
            var game = $(event.target).data('game');
			$('.openAddClear').attr('href', '{{ route('backend.game.gamebanks_clear') }}?type=' + type + '&game=' + game);
			$('#gamebank_add').attr('action', '{{ route('backend.game.gamebanks_add') }}?type=' + type + '&game=' + game);

			$('#AddSum').val('');
		});
		$('.changeAddSum').click(function(event){
			$v = parseInt($('#AddSum').val().replace(/,/g, ''));
			if (isNaN($v)) $v = 0;

			if ($(event.target).data('value') == 0)
			{
				$('#AddSum').val(0);
			}
			else
			{
				const val = $v + $(event.target).data('value');
				$('#AddSum').val(val.toLocaleString());
			}
			$('#AddSum').focus();
		});
	</script>
@endpush