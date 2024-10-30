@extends('backend.White.layouts.app')

@section('page-title', '회원목록')
@section('page-heading', '회원목록')

@section('content')

  @include('backend.White.partials.messages')

	<div class="container-fluid py-4">
    <div class="row mt-4" id="toggle-box">
      <div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
        <div class="card ">
          <div class="card-header bg-transparent p-3">
              <div
                  class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">person_add</i>
              </div>
              <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize ">전체 회원수</p>
                  <h4 class="mb-0 ">{{ number_format($stat['totaluser'], 0) }}</h4>
              </div>
          </div>
        </div>
        <div class="card mt-4">
          <div class="card-header bg-transparent p-3">
              <div
                  class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize ">온라인 회원수</p>
                  <h4 class="mb-0 ">{{ number_format($stat['onlineuser'], 0) }}</h4>
              </div>
          </div>
        </div>
        <div class="card mt-4">
          <div class="card-header bg-transparent p-3">
              <div
                  class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">payments</i>
              </div>
              <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize ">회원 보유머니</p>
                  <h4 class="mb-0 ">{{ number_format($stat['totalbalance'], 0) }}</h4>
              </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-8 col-md-6">
        <div class="card mb-3">
          <div class="card-header">
            <p class="text-sm mb-0 font-weight-bolder">실행중인 게임</p>
          </div>
          <div class="card-body pt-0">
            <div class="chart" style="position: relative; height: 225px;">
              <canvas id="pie-chart" class="chart-canvas"></canvas>
            </div>
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
                    <label>회원 아이디</label>
								    <input type="text" class="form-control" name="search" value="{{ Request::get('search') }}">
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group input-group-static">
                    <label>@lang('app.status')</label>
                    {!! Form::select('status', $statuses, Request::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-6">
                  <div class="input-group input-group-static">
                    <label>매장 아이디</label>
                    <input type="text" class="form-control" name="shopname" value="{{ Request::get('shopname') }}">
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group input-group-static">
                    <label>정렬</label>
                    {!! Form::select('orderby', ['알파벳','보유금'], Request::get('orderby'), ['class' => 'form-control', 'id' => 'orderby']) !!}
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
            @permission('users.add')
						<!-- @if (Auth::user()->hasRole('admin') && !Session::get('isCashier'))
						<a href="{{ route('backend.user.createuserfromcsv') }}" class="btn btn-danger btn-sm" style="margin-right:5px;">csv로 추가</a>
						@endif -->
						@if (Auth::user()->hasRole('cashier') || Auth::user()->hasRole('manager'))
            <div class="d-flex">
              <a href="{{ route('backend.user.create') }}" class="btn bg-gradient-primary ms-auto">회원 추가</a>
            </div>
						@endif
						@endpermission
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-xs font-weight-bolder opacity-7 px-2">이름(아이디)</th>
                  <th class="text-xs font-weight-bolder opacity-7 px-2">매장이름</th>
                  @if (auth()->user()->hasRole(['admin','comaster','master','agent']))
                  <th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','distributor')->first()->description}}</th>
                  @endif
                  @if (auth()->user()->hasRole(['admin','comaster','master']))
                  <th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','agent')->first()->description}}</th>
                  @endif
                  @if (auth()->user()->hasRole(['admin','comaster']))
                  <th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','master')->first()->description}}</th>
                  @endif
                  @if ( auth()->check() && auth()->user()->hasRole(['admin']) )
                  <th class="text-xs font-weight-bolder opacity-7 px-2">{{\VanguardLTE\Role::where('slug','comaster')->first()->description}}</th>
                  @endif
                  @permission('users.balance.manage')
                  <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.balance')</th>
                  <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.total_in')</th>
                  <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.total_out')</th>
                  <!-- <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.wager')</th> -->
                  <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.status')</th>
                  <th></th>
                  @endpermission
                </tr>
              </thead>
              <tbody>
                @if (count($users))
                  @foreach ($users as $user)
                    @include('backend.White.user.partials.row')
                  @endforeach
                @else
                  <tr><td colspan="7">@lang('app.no_data')</td></tr>
                @endif
              </tbody>
            </table>
            {{ $users->appends(Request::except('page'))->links() }}
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
              <h5 class=""><span id="in-user"></span>회원 @lang('app.pay_in')</h5>
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
              <h5 class=""><span id="out-user"></span>회원 @lang('app.pay_out')</h5>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    var chartData = @json($userGroups);

    var labels = ['없음'];
    var data = [1];
    if (Object.keys(chartData).length > 0) {
      labels = Object.keys(chartData).map(key => chartData[key].playing_game);
      data = Object.keys(chartData).map(key => chartData[key].count);
    }

    const chartConfig = {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: [
          'rgba(63, 81, 181, 0.5)', 
          'rgba(77, 182, 172, 0.5)', 
          'rgba(66, 133, 244, 0.5)', 
          'rgba(156, 39, 176, 0.5)', 
          'rgba(233, 30, 99, 0.5)', 
          'rgba(66, 73, 244, 0.4)', 
          'rgba(166, 73, 244, 0.4)',
          'rgba(66, 173, 244, 0.4)',
          'rgba(66, 73, 144, 0.4)',
          'rgba(66, 133, 244, 0.2)'],
      }],
    }

    const myChart = new Chart(
      document.getElementById("pie-chart"),
      {
        type: 'pie',
        data: chartConfig,
        options: {
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'right',
              maxHeight: 250
            }
          }
        }
      }
    );
  </script>

	<script>

		$(function() {

		$("#view").change(function () {
			$("#shops-form").submit();
		});

		$("#filter").detach().appendTo("div.toolbar");


		$("#status").change(function () {
			$("#users-form").submit();
		});
		$("#role").change(function () {
			$("#users-form").submit();
		});
		$("#shop_id").change(function () {
			$("#users-form").submit();
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
		$('#btnAddSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#addForm').submit();
		});
		$('#btnOutSum').click(function() {
			$(this).attr('disabled', 'disabled');
			$('form#outForm').submit();
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

		$('.changeOutSum').click(function(event){
			$v = parseInt($('#OutSum').val().replace(/,/g, ''));
			if (isNaN($v)) $v = 0;

			if ($(event.target).data('value') == 0)
			{
				$('#OutSum').val(0);
			}
			else
			{
				const val = $v + $(event.target).data('value');
				$('#OutSum').val(val.toLocaleString());
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
			$('#out-user').text(user);
			$('#outAll').val('');
		});

		$('#doOutAll').click(function () {
			$(this).attr('disabled', 'disabled');
			$('#outAll').val('1');
			$('form#outForm').submit();
		});

		});
	</script>
@endpush