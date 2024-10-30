<tr>
	
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($stat->shop)
		{{ $stat->shop->name }}
	@else
		삭제된 매장 - {{$stat->shop_id}}
	@endif
	</p></td>
	<td>
	<?php  
		$available_roles = \jeremykenedy\LaravelRoles\Models\Role::orderby('id')->pluck('name', 'id');
		$available_roles_trans = [];
		foreach ($available_roles as $key=>$role)
		{
			$role = \VanguardLTE\Role::find($key)->description;
			$available_roles_trans[$key] = $role;
		}
	?>
	@if ($stat->user)
		<p class="text-sm font-weight-normal mb-0">{{ $stat->user ? $stat->user->username : 'unknown'  }} [ {{$available_roles_trans[$stat->user->role_id]}} ]</p>
	@else
		<p class="text-sm font-weight-normal mb-0">삭제된 파트너 - {{$stat->user_id}}</p>
	@endif
	</td>
	@if (auth()->user()->isInoutPartner())
	<td>
		<p class="text-sm font-weight-normal mb-0">{{number_format($stat->balance,0)}}</p>
	</td>
	@endif
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ number_format($stat->old,0) }}</p>
	</td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ number_format($stat->new,0) }}</p>
	</td>
	<td>
		@if ($stat->type == 'add')
			<p class="text-success text-sm font-weight-normal mb-0">{{ number_format(abs($stat->sum),0) }}</p>
		@endif
	</td>
	<td>
		@if ($stat->type == 'out')
			<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->sum),0) }}</p>
		@endif
	</td>
	<td>
		@if ($stat->type == 'deal_out')
			<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->sum),0) }}</p>
		@endif
	</td>
	@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td>
		@if ($stat->type == 'ggr_out')
			<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->sum),0) }}</p>
		@endif
	</td>
	@endif
	@if($stat->requestInfo)
	<td><p class="text-sm font-weight-normal mb-0"> {{"[ " . $stat->requestInfo->bank_name . " ] ". $stat->requestInfo->account_no}} </p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ $stat->requestInfo->recommender }}</p></td>
	@else
	<td></td>
	<td></td>
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($stat->date_time)) }}</p></td>
	@if(isset($show_shop) && $show_shop)
		@if($stat->shop)
			<td><a href="{{ route('backend.shop.edit', $stat->shop->id) }}"><p class="text-sm font-weight-bold mb-0">{{ $stat->shop->name }}</p></a></td>
		@endif
	@endif
</tr>