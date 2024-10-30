<tr>        
    <td>
		<a href="{{ route('backend.shop.edit', $shop->id) }}">
			<p class="ps-1 text-sm font-weight-bold mb-0">{{ $shop->name }}</p>
		</a>
	</td>
	@if($shop->creator)
		@if (auth()->user()->hasRole(['admin','comaster','master','agent']))
		<td>
			<a href="{{ route('backend.user.edit', $shop->creator->id) }}" >
				<p class="ps-1 text-sm font-weight-bold mb-0">{{ $shop->creator->username }}</p>
			</a>
		</td>
		@endif
	@endif
	@if($shop->creator && $shop->creator->referral)
		@if (auth()->user()->hasRole(['admin','comaster','master']))
		<td>
			<a href="{{ route('backend.user.edit', $shop->creator->referral->id) }}" >
				<p class="ps-1 text-sm font-weight-bold mb-0">{{ $shop->creator->referral->username }}</p>
			</a>
		</td>
		@endif
	@endif

	@if($shop->creator && $shop->creator->referral && $shop->creator->referral->referral)
		@if (auth()->user()->hasRole(['admin','comaster']))
		<td>
			<a href="{{ route('backend.user.edit',  $shop->creator->referral->referral->id) }}" >
				<p class="ps-1 text-sm font-weight-bold mb-0">{{  $shop->creator->referral->referral->username }}</p>
			</a>
		</td>
		@endif
	@endif
	
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($shop->balance,0) }}</p>
	</td>
	@if(auth()->user()->hasRole('admin'))
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $shop->percent }}</p>
	</td>
	@endif
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($shop->deal_balance,0) }}</p>
	</td>
	@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($shop->ggr_balance-$shop->count_deal_balance,0) }}</p>
	</td>
	@endif
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $shop->deal_percent }}</p>
	</td>
	<td><p class="ps-1 text-sm font-weight-normal mb-0">{{ $shop->table_deal_percent }}</p></td>
	@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $shop->ggr_percent }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $shop->reset_days??0 }}일</p>
	</td>
	<td>
		@if ($shop->ggr_percent > 0)
		<p class="ps-1 text-sm font-weight-normal mb-0">{{$shop->last_reset_at?\Carbon\Carbon::parse($shop->last_reset_at)->addDays($shop->reset_days):date('Y-m-d 00:00:00', strtotime("+" . $shop->reset_days . " days"))}}</p>
		@endif
	</td>
	@endif
	<td>
		@if($shop->is_blocked)
			<span class="badge badge-sm bg-gradient-danger" title="차단"> </span>
		@elseif($shop->pending)
			<span class="badge badge-sm bg-gradient-warning" title="준비중"> </span>
		@else
			<span class="badge badge-sm bg-gradient-success" title="활성"> </span>
		@endif
	</td>
	<td class="text-center">
		@if((auth()->user()->isInoutPartner() || auth()->user()->hasRole('distributor')) &&  !$shop->is_blocked)
		<button class="addPayment btn bg-gradient-success btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openAddModal" data-id="{{ $shop->shop_id }}" data-shop="{{$shop->name}}">@lang('app.in')</button>
		@else
			<button type="button" class="btn btn-secondary disabled btn-sm mb-0 text-xs"> 충전</button>
		@endif
	
		@if((auth()->user()->isInoutPartner() || auth()->user()->hasRole('distributor')) &&  !$shop->is_blocked)
		<button class="outPayment btn bg-gradient-warning btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openOutModal" data-id="{{ $shop->shop_id }}" data-shop="{{$shop->name}}" data-available="{{number_format($shop->balance,0)}}">@lang('app.out')</button>
		@else
			<button type="button" class="btn btn-secondary disabled btn-sm mb-0 text-xs"> 환전</button>
		@endif
	</td>
</tr>