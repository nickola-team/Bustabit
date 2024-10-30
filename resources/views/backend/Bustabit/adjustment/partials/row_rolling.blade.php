<tr>
	<td><p class="text-sm font-weight-normal mb-0">{{ $rolling_log->shop->name }}</p></td>
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
	@if ($rolling_log->user)
		<p class="text-sm font-weight-normal mb-0">{{ $rolling_log->user ? $rolling_log->user->username : 'unknown'  }} [ {{$available_roles_trans[$rolling_log->user->role_id]}} ]</p>
	@else
		<p class="text-sm font-weight-normal mb-0">삭제된 파트너 - {{$rolling_log->user_id}}</p>
	@endif
	</td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ number_format($rolling_log->old,0) }}</p>
	</td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ number_format($rolling_log->new,0) }}</p>
	</td>
	<td>
		<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format(abs($rolling_log->sum),0) }}</p>
	</td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($rolling_log->date_time)) }}</p>
	</td>	
</tr>