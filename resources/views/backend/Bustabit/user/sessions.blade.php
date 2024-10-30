@extends('backend.White.layouts.app')

@section('page-title', trans('app.active_sessions'))
@section('page-heading', trans('app.active_sessions'))

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
	    <div class="row mt-4">
			<div class="col-12">
				<div class="card">
                    <div class="card-header">
                        <h5 class="card-title ">@lang('app.sessions') - {{ $user->present()->username }}</h5>
                    </div>
                    <div class="card-body pt-0">
    					<div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">IP</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.device')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.browser')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.last_activity')</th>
                                        <th class="text-xs font-weight-bolder opacity-7 px-2">@lang('app.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($sessions))
                                        @foreach ($sessions as $session)
                                        <tr>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ $session->ip_address }}</p></td>
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{ $session->device ?: trans('app.unknown') }} ({{ $session->platform ?: trans('app.unknown') }})</p>
                                            </td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ $session->browser ?: trans('app.unknown') }}</p></td>
                                            <td><p class="text-sm font-weight-normal mb-0">{{ $session->last_activity->format(config('app.date_time_format')) }}</p></td>
                                            <td>
                                                <a href="{{ isset($profile) ? route('backend.profile.sessions.invalidate', $session->id) : route('backend.user.sessions.invalidate', [$user->id, $session->id]) }}"
                                                class="btn bg-gradient-danger btn-sm mb-0"
                                                data-method="DELETE"
                                                data-confirm-title="@lang('app.please_confirm')"
                                                data-confirm-text="@lang('app.are_you_sure_invalidate_session')"
                                                data-confirm-delete="@lang('app.yes_proceed')">
                                                    @lang('app.invalidate_session')
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
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