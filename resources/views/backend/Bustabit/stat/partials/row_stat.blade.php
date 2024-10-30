<tr>
<?php  
		$available_roles = \jeremykenedy\LaravelRoles\Models\Role::orderby('id')->pluck('name', 'id');
		$available_roles_trans = [];
		foreach ($available_roles as $key=>$role)
		{
			$role = \VanguardLTE\Role::find($key)->description;
			$available_roles_trans[$key] = $role;
		}
	?>
<td>
	@if ($stat->user)
	@if ($partner==0)
		<a href="{{ route('backend.statistics', ['user' => $stat->user->username])  }}">
			<p class="text-sm font-weight-bold mb-0">{{ $stat->user->username }}</p>
		</a>
	@else
		<a href="{{ route('backend.statistics_partner', ['user' => $stat->user->username])  }}">
			<p class="text-sm font-weight-bold mb-0">{{ $stat->user->username }} [ {{$available_roles_trans[$stat->user->role_id]}} ]</p>
		</a>
	@endif
	@else
		<p class="text-sm font-weight-normal mb-0">삭제된 유저 - {{$stat->user_id}}</p>
	@endif
</td>
<td>
	@if ($stat->admin)
	<p class="text-sm font-weight-normal mb-0">{{ $stat->admin ? $stat->admin->username : $stat->system  }} [ {{$available_roles_trans[$stat->admin->role_id]}} ]</p>
	@else
	<p class="text-sm font-weight-normal mb-0">Unknown</p>
	@endif

</td>
@if ($partner==0)
<td><p class="text-sm font-weight-normal mb-0">{{number_format($stat->balance,0)}}</p></td>
@else
@if (auth()->user()->isInoutPartner())
<td><p class="text-sm font-weight-normal mb-0">{{number_format($stat->balance,0)}}</p></td>
@endif
@endif

<td>
	<p class="text-sm font-weight-normal mb-0">{{number_format($stat->old,0)}}</p>
</td>
<td>
	<p class="text-sm font-weight-normal mb-0">{{number_format($stat->new,0)}}</p>
</td>
<td>
@if ($stat->type == 'add')
	<p class="text-success text-sm font-weight-normal mb-0">{{ number_format(abs($stat->summ),0) }}</p>
@endif
</td>
<td>
	@if ($stat->type == 'out')
		<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->summ),0) }}</p>
	@endif
</td>
@if ($partner==1)
<td>
	@if ($stat->type == 'deal_out')
		<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->summ),0) }}</p>
	@endif
</td>
@if (auth()->user()->hasRole('admin')  || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
<td>
	@if ($stat->type == 'ggr_out')
	<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($stat->summ),0) }}</p>
	@endif
</td>
@endif
@if($stat->requestInfo)
<td> <p class="text-sm font-weight-normal mb-0">{{"[ " . $stat->requestInfo->bank_name . " ] ". $stat->requestInfo->account_no}}</p> </td>
<td><p class="text-sm font-weight-normal mb-0">{{ $stat->requestInfo->recommender }}</p></td>
@else
<td></td>
<td></td>
@endif
@endif
<td><p class="text-sm font-weight-normal mb-0">{{ $stat->created_at->format(config('app.date_time_format')) }}</p></td>
	@if(isset($show_shop) && $show_shop)
		@if($stat->shop)
			<td><a href="{{ route('backend.shop.edit', $stat->shop->id) }}">
				<p class="text-sm font-weight-bold mb-0">{{ $stat->shop->name }}</p></a>
			</td>
			@else
			<td>@lang('app.no_shop')</td>
		@endif
	@endif
</tr>