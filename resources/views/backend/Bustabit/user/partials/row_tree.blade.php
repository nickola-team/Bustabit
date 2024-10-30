<td>
    @if ( $user['role_id'] > 3 )
    <a href="{{ route('backend.user.tree') }}?parent={{$user['id']}}">
    @endif
    <p class="text-sm font-weight-normal mb-0">{{ $user['name'] }}</p>
    @if ( $user['role_id'] > 3 )
    </a>
@endif
</td>
<?php  
    $available_roles = Auth::user()->available_roles( true );
    $available_roles_trans = [];
    foreach ($available_roles as $key=>$role)
    {
        $role = \VanguardLTE\Role::find($key)->description;
        $available_roles_trans[$key] = $role;
    }
?>
<td>
    <p class="text-sm font-weight-normal mb-0">{{ $available_roles_trans[$user['role_id']] }}</p>
</td>
@if ( isset($user['shop']) && empty(Request::get('search')) )
<td>
    <a href="{{ route('backend.shop.edit', $user['shop_id']) }}">
        <p class="text-sm font-weight-normal mb-0">{{ $user['shop'] }}</p>
    </a>
</td>
@endif
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['balance'],0) }}</p></td>
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['profit'],0) }}</p></td>
@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['ggr_profit'],0) }}</p></td>
@endif
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['deal_percent'],2) }}</p></td>
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['table_deal_percent'],2) }}</p></td>
@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
<td><p class="text-sm font-weight-normal mb-0">{{ number_format($user['ggr_percent'],2) }}</p></td>
<!-- <td>{{ $user['reset_days']??0 }}일</td> -->
@endif

<td class="text-center">
    <a href="{{ route('backend.user.edit', $user['id']) }}">
    <button class="btn bg-gradient-info btn-sm text-xs mb-0">편집</button>
    </a>
    @if ($user['role_id']!=3 && (auth()->user()->isInoutPartner() || ($user['id']!=auth()->user()->id && auth()->user()->role_id == $user['role_id']+1)))
    <button class="newPayment addPayment btn bg-gradient-success btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openAddModal" data-id="{{ $user['id'] }}" data-user="{{$user['name']}}">@lang('app.in')</button>
    @else
    <button class="btn btn-secondary disabled btn-sm mb-0 text-xs" disabled>@lang('app.in')</button>
    @endif
    @if ($user['role_id']!=3 && auth()->user()->isInoutPartner())
    <button class="newPayment outPayment btn bg-gradient-warning btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openOutModal" data-id="{{ $user['id'] }}" data-user="{{$user['name']}}" data-available="{{number_format($user['balance'],0)}}">@lang('app.out')</button>
    @else
    <button type="button" class="btn btn-secondary disabled btn-sm text-xs mb-0" disabled>@lang('app.out')</button>
    @endif
</td>


