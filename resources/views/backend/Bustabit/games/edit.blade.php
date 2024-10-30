@extends('backend.White.layouts.app')
@section('page-title', '게임상세')

@section('content')

    @include('backend.White.partials.messages')

	<div class="container-fluid py-4">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('app.line_chart')</h4>
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $game->title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <tbody>
                                    @permission('games.in_out')
                                    <tr>
                                        <td>베팅횟수</td>
                                        <td>{{ $bids }}</td>
                                    </tr>
                                    <tr>
                                        <td>베팅금</td>
                                        <td>{{ number_format($stat_in) }}</td>
                                    </tr>
                                    <tr>
                                        <td>당첨금</td>
                                        <td>{{ number_format($stat_out) }}</td>
                                    </tr>
                                    <tr>
                                        <td>벳윈</td>
                                        <td>
                                            <span class="{{ ($stat_in - $stat_out) >= 0 ? 'text-success' : 'text-danger'}}">
                                            {{ number_format($stat_in-$stat_out) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('app.rtp')</td>
                                        <td>{{ $stat_in > 0 ? number_format(($stat_out / $stat_in) * 100, 2, '.', '') : '0.00' }} %</td>
                                    </tr>
                                    <tr>
                                        <td>플레이중인 유저</td>
                                        <td>{{ $playing_count }}</td>
                                    </tr>
                                    @endpermission
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">최신 베팅내역</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>@lang('app.user')</th>
                                        <th>@lang('app.bet')</th>
                                        <th>@lang('app.win')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($game_stat))
                                        @foreach ($game_stat as $stat)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('backend.game_stat', ['user' => $stat->user->username])  }}">
                                                        {{ $stat->user->username }}
                                                    </a>
                                                </td>
                                                <td>{{ $stat->bet }}</td>
                                                <td>{{ $stat->win }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="2">@lang('app.no_data')</td></tr>
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
