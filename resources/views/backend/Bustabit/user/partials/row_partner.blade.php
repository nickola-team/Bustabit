<td>
        @if (Session::get('isCashier'))
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ $user->username }}</p>
        @else
        <a href="{{ route('backend.user.edit', $user->id) }}">
                <p class="ps-1 text-sm font-weight-bold mb-0">{{ $user->username }}</p>
        </a>
        @endif
</td>
<?php
        $parent = $user->referral;
        for ($r=$role_id+1;$r<auth()->user()->role_id;$r++)
        {
             echo '<td><a href="'.route('backend.user.edit', $parent->id).'"><p class="ps-1 text-sm font-weight-bold mb-0">'.$parent->username.'</p></a></td>';
            $parent = $parent->referral;
        }
?>
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->balance,0) }}</p>
</td>
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->deal_balance - $user->mileage,0) }}</p>
</td>
@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->ggr_balance - $user->ggr_mileage - ($user->count_deal_balance - $user->count_mileage),0) }}</p>
</td>
@endif
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->deal_percent,2) }}</p>
</td>
<td><p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->table_deal_percent,2) }}</p></td>
@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($user->ggr_percent,2) }}</p>
</td>
<td>
        <p class="ps-1 text-sm font-weight-normal mb-0">{{ $user->reset_days??0 }}일</p>
</td>
@endif

<td>
@if ($user->ggr_percent > 0)
        @if( $user->hasRole(['cashier', 'manager']) )
        <p class="ps-1 text-sm font-weight-normal mb-0">{{$user->shop->last_reset_at?\Carbon\Carbon::parse($user->shop->last_reset_at)->addDays($user->shop->reset_days):date('Y-m-d 00:00:00', strtotime("+" . $user->shop->reset_days . " days"))}}</p>
        @else
        <p class="ps-1 text-sm font-weight-normal mb-0">{{$user->last_reset_at?\Carbon\Carbon::parse($user->last_reset_at)->addDays($user->reset_days):date('Y-m-d', strtotime("+" . $user->reset_days . " days"))}}</p>
        @endif
@endif
</td>
@if ($user->role_id == 7)
<!-- <td>{{ number_format($user->money_percent,2) }}</td> -->
@endif
@if ($user->role_id == 6)
<td>
        @if ($user->ggr_percent > 0)
        <button class="newReset allowReset btn bg-gradient-danger btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openResetModal" data-id="{{ $user['id'] }}" data-user="{{$user['username']}}">리셋</button>
        @else
        <button type="button" class="btn btn-secondary disabled btn-sm mb-0 text-xs" disabled>리셋</button>
        @endif
</td>
@endif

<td class="text-center">
        @if (auth()->user()->isInoutPartner() || (auth()->user()->role_id == $user->role_id+1))
        <button class="newPayment addPayment btn bg-gradient-success btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openAddModal" data-id="{{ $user['id'] }}" data-user="{{$user['username']}}">@lang('app.in')</button>
        @else
        <button type="button" class="btn btn-secondary disabled btn-sm mb-0 text-xs" disabled>@lang('app.in')</button>
        @endif

        @if (auth()->user()->isInoutPartner() || (auth()->user()->role_id == $user->role_id+1))
        <button class="newPayment outPayment btn bg-gradient-warning btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openOutModal" data-id="{{ $user['id'] }}" data-user="{{$user['username']}}" data-available="{{number_format($user['balance'],0)}}">@lang('app.out')</button>
        @else
        <button type="button" class="btn btn-secondary disabled btn-sm text-xs mb-0" disabled>@lang('app.out')</button>
        @endif
</td>


