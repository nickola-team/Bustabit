@extends('backend.White.layouts.app')

@section('page-title', trans('app.dashboard'))
@section('page-heading', trans('app.dashboard'))

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
		<div class="row mt-4">
			<div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
				<div class="card ">
					<div class="card-header p-3 pt-2 bg-transparent">
						<div
							class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
							<i class="material-icons opacity-10">add</i>
						</div>
						<div class="text-end pt-1">
							<p class="text-sm mb-0 text-capitalize ">@lang('app.new_users_this_month')</p>
							<h4 class="mb-0 ">{{ number_format($stats['new']) }}</h4>
						</div>
					</div>
					<hr class="horizontal my-0 dark">
					<div class="card-footer p-3">
                        <a href="{{ route('backend.user.list') }}">
                            @lang('app.more_info')
                        </a>
					</div>
				</div>
			</div>
		</div>

        <!-- 최근충환전내역 -->
        @permission('stats.pay')
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('app.latest_pay_stats')</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.system')</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">충/환전금액</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">회원/파트너</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.date')</th>
                                </thead>
                                
                                <tbody>
                                    @if (count($statistics))
                                        @foreach ($statistics as $stat)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('backend.statistics', ['system_str' => $stat->admin ? $stat->admin->username : $stat->system])  }}">
                                                        <p class="text-sm font-weight-bold mb-0">{{ $stat->admin ? $stat->admin->username : $stat->system }}</p>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0 {{ $stat->type == 'add' ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format(abs($stat->summ),0) }}</p>
                                                </td>
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.statistics', ['user' => $stat->user ? $stat->user->username : ''])  }}">
                                                        <p class="text-sm font-weight-bold mb-0">{{ $stat->user ? $stat->user->username : '' }}</p>
                                                    </a>
                                                </td>
                                                <td><p class="text-sm font-weight-normal mb-0">{{ $stat->created_at->format(config('app.date_time_format')) }}</p></td>
                                            </tr>
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
        </div>
        @endpermission

        <!-- 최근 베팅내역 -->
        @permission('stats.game')
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title ">@lang('app.latest_game_stats')</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.game')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.user')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.balance')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.bet')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.win')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.date')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @if (count($gamestat))
                                    @foreach ($gamestat as $stat)
                                        <tr>
                                            <td>
                                                <a href="{{ route('backend.game_stat', ['game' => $stat->game])  }}">
                                                    <p class="text-sm font-weight-bold mb-0">{{ $stat->game }}</p>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('backend.game_stat', ['user' => $stat->user ? $stat->user->username : ''])  }}">
                                                    <p class="text-sm font-weight-bold mb-0">{{ $stat->user ? $stat->user->username : '' }}</p>
                                                </a>
                                            </td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ number_format($stat->balance,0) }}</p></td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ number_format($stat->bet) }}</p></td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ number_format($stat->win) }}</p></td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($stat->date_time)) }}</p></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6">@lang('app.no_data')</td></tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endpermission
    </div>
@endsection