@extends('backend.White.layouts.app')

@section('page-title', trans('app.edit_user'))
@section('page-heading', $user->present()->username)

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
        <div class="card card-body mx-3 mx-md-4">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/assets/img/{{ $user->present()->role_id }}.png" alt="{{ $user->present()->username }}" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->present()->username }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            @lang('app.balance') &nbsp; <span class="text-success">{{ number_format($user->present()->balance,0) }}</span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            @if($user->hasRole('user'))
                            <li class="nav-item" role="presentation">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="pill" data-bs-target="#game-logs" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="material-icons text-lg position-relative">data_usage</i>
                                    <span class="ms-1">최근 베팅</span>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <a class="nav-link mb-0 px-0 py-1 {{ !$user->hasRole('user') ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#bonus-details" href="javascript:;" role="tab" aria-selected="{{ $user->hasRole('user') ? 'false' : 'true' }}">
                                    <i class="material-icons text-lg position-relative">paid</i>
                                    <span class="ms-1">최근 충환전</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="pill" data-bs-target="#login-details" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="material-icons text-lg position-relative">login</i>
                                    <span class="ms-1">@lang('app.latest_activity')</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="pill" data-bs-target="#details" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="material-icons text-lg position-relative">settings</i>
                                    <span class="ms-1">@lang('app.edit_user')</span>
                                </a>
                            </li>
                            @if(auth()->user()->hasRole('admin') && $user->hasRole(['agent', 'distributor', 'manager']) )
                            <!-- <li class="nav-item" role="presentation">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="pill" data-bs-target="#partner-move" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="material-icons text-lg position-relative">settings</i>
                                    <span class="ms-1">파트너이동</span>
                                </a>
                            </li> -->
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                @if($user->hasRole('user'))
                <div class="tab-pane active" id="game-logs" role="tabpanel">
                    <div class="card card-body">
                        <div class="table-responsive mt-3">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">게임사</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">게임명</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">베팅금액</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">당첨금액</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">보유금액</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">베팅시간</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($gameLogs))
                                    @foreach ($gameLogs as $log)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-normal mb-0">{{$log->category->trans_kr}}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-normal mb-0">{{get_gamename($log->category->game_code, $log->game, $log->type)}}</p>
                                        </td>
                                        <td>
                                            <p class="text-success text-sm font-weight-normal mb-0">{{ number_format($log->bet, 0) }}</p>
                                        </td>
                                        <td>
                                            <p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($log->win, 0) }}</p>
                                        </td>
                                        <td>
                                            <p class="text-info text-sm font-weight-normal mb-0">{{ number_format($log->balance, 0) }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-normal mb-0">{{ $log->date_time }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="5">@lang('app.no_data')</td></tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $gameLogs->appends(Request::except('page'))->links() }}
                        </div>
                    </div>
                </div>
                @endif
                <div class="tab-pane" id="details" role="tabpanel">
                    {!! Form::open(['route' => ['backend.user.update.details', $user->id], 'method' => 'PUT', 'id' => 'details-form']) !!}
                    @include('backend.White.user.partials.edit')
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane" id="partner-move" role="tabpanel">
                    {!! Form::open(['route' => ['backend.user.update.move', $user->id], 'method' => 'POST', 'id' => 'details-form']) !!}
                    @include('backend.White.user.partials.move')
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane" id="login-details" role="tabpanel">
                    <div class="card card-body">
                        @if (count($userActivities))
                            <div class="table-responsive mt-3">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">유형</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.date')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userActivities as $activity)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{ $activity->description }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{ $activity->created_at->format(config('app.date_time_format')) }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted font-weight-light"><em>@lang('app.no_activity_from_this_user_yet')</em></p>
                        @endif
                    </div>
                </div>
                <div class="tab-pane {{ !$user->hasRole('user') ? 'active' : '' }}" id="bonus-details" role="tabpanel">
                    <div class="card card-body">
                        <div class="table-responsive mt-3">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">이전포인트</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">이후포인트</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">충전</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">환전</th>
                                    <th class="text-xs font-weight-bolder opacity-7 px-2">시간</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($statistics))
                                    @foreach ($statistics as $stat)
                                        @include('backend.White.user.partials.row_stat')
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
@endsection

@push('js')
    <script>
        $(function() {
            $('input[name="dates"]').daterangepicker({
                timePicker: false,
                startDate: moment().format('YYYY-MM-DD'),

                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>
@endpush