<tr>
    <td>
        <a href="{{ route('backend.user.edit', $user->id) }}">
			<p class="ps-1 text-sm font-weight-bold mb-0">{{ $user->username ?: trans('app.n_a') }}</p>
        </a>
    </td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $user->shop->name}}</p>
	</td>
	<?php
		$parent = $user->referral;
		$role_id = $parent->role_id;
		for ($r=$role_id+1;$r<auth()->user()->role_id;$r++)
		{
			if ($parent){
				$parent = $parent->referral;
			}
			if ($parent)
			{
				echo '<td><a href="'.route('backend.user.edit', $parent->id).'"><p class="text-sm font-weight-bold mb-0">'.$parent->username.'</p></a></td>';
			}
			else
			{
				echo '<td><a href="#">unknown</a></td>';
			}
		}
	?>

	@permission('users.balance.manage')
	<td>
		<p class="text-info text-sm font-weight-normal mb-0">{{ number_format($user->balance,0) }}</p>
	</td>
	<td>
		<p class="text-success text-sm font-weight-normal mb-0">{{ number_format($user->total_in,0) }}</p>
	</td>
	<td>
		<p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($user->total_out,0) }}</p>
	</td>
	<!-- <td>{{ number_format($user->wager,0) }}</td> -->
	@if(isset($user->playing_game))
	<td>
		<span class="badge badge-sm bg-gradient-success" title="온라인"> </span>
	</td>
	@elseif($user->status == 'Active')
	<td>
		<span class="badge badge-sm bg-gradient-secondary" title="오프라인"> </span>
	</td>
	@elseif($user->status == 'Banned')
	<td>
		<span class="badge badge-sm bg-gradient-danger" title="차단"> </span>
	</td>
	@else
	<td>
		<span class="badge badge-sm bg-gradient-warning" title="미승인"> </span>
	</td>
	@endif
	<td class="text-center">
		@if(isset($user->playing_game))
		<a href="{{ route('backend.user.balance.reset', ['id' => $user->id]) }}"
			class="btn bg-gradient-primary btn-sm mb-0 text-xs"
			data-method="DELETE"
			data-confirm-title="경고"
			data-confirm-text="회원상태를 리셋하시겟습니까?"
			data-confirm-delete="확인">
				리셋
			</a>
		@else
		<button type="button" class="btn btn-secondary disabled btn-sm mb-0 text-xs">리셋</button>
		@endif
		<a href="{{ route('backend.user.balance.refresh', ['id' => $user->id]) }}" class="btn bg-gradient-info btn-sm mb-0 text-xs">
			새로고침
		</a>
		@if (isset($user->playing_game))
		<button class="btn btn-secondary disabled btn-sm mb-0 text-xs">@lang('app.in')</button>
		@elseif( auth()->user()->isInoutPartner() || auth()->user()->hasRole('manager') || !isset($user->playing_game))
		<button class="newPayment addPayment btn bg-gradient-success btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openAddModal" data-id="{{ $user->id }}" data-user="{{$user->username}}">@lang('app.in')</button>
		@else
		<button class="btn btn-secondary disabled btn-sm mb-0 text-xs">@lang('app.in')</button>
		@endif
		@if (isset($user->playing_game))
		<button class="btn btn-secondary disabled btn-sm mb-0 text-xs">@lang('app.out')</button>
		@elseif( auth()->user()->isInoutPartner() || auth()->user()->hasRole('manager'))
		<button class="newPayment outPayment btn bg-gradient-warning btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openOutModal" data-id="{{ $user->id }}" data-user="{{$user->username}}" data-available="{{number_format($user->balance,0)}}">@lang('app.out')</button>
		@else
		<button class="btn btn-secondary disabled btn-sm text-xs mb-0">@lang('app.out')</button>
		@endif
	</td>
    @endpermission

	@if(isset($show_shop) && $show_shop)
		@if($user->shop)
			<td><a href="{{ route('backend.shop.edit', $user->shop->id) }}">{{ $user->shop->name }}</a></td>
			@else
			<td></td>
		@endif
	@endif
</tr>