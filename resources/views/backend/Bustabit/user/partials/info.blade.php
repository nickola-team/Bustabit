<div class="card card-profile">
    <div class="card-avatar">
        <a href="#">
            <img class="img" src="/back/img/{{ $user->present()->role_id }}.png" alt="{{ $user->present()->username }}">
        </a>
    </div>
    <div class="card-body">
    <h4 class="card-title"><small><i class="fa fa-circle text-{{ $user->present()->labelClass }}"></i></small> {{ $user->present()->username }}</h4>
    <div class="card-description">
        <table class="table">
            <tbody>
                <tr>
                    <td>@lang('app.balance')</td> <td>{{ number_format($user->present()->balance,0) }}</td>
                </tr>

                @if( $user->hasRole('user') )
                <tr>
                    <td>@lang('app.in')</td> <td>{{ number_format($user->present()->total_in,0) }}</td>
                </tr>
                <tr>
                    <td>@lang('app.out')</td> <td>{{ number_format($user->present()->total_out,0) }}</td>
                </tr>
                <tr>
                    <td>@lang('app.total')</td> <td>{{ number_format($user->present()->total_in - $user->present()->total_out,0) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if( $user->id != Auth::id() )
        @if(auth()->user()->isInoutPartner())
            @permission('users.delete')
            <a href="{{ route('backend.user.delete', $user->id) }}"
                class="btn btn-danger"
                data-method="DELETE"
                data-confirm-title="회원 삭제"
                data-confirm-text="정말 삭제하시겠습니까?"
                data-confirm-delete="확인">
                <b>@lang('app.delete')</b></a>
            @endpermission
        @endif

        @if(auth()->user()->hasRole('admin') )
            <a href="{{ route('backend.user.hard_delete', $user->id) }}"
                class="btn btn-danger"
                data-method="DELETE"
                data-confirm-title="어드민 삭제"
                data-confirm-text="정말 삭제하시겠습니까?"
                data-confirm-delete="확인">
                <b>어드민삭제</b></a>
        @endif

    @endif
    </div>
</div>