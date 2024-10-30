<tr>
	<td>
	@if($adjustment['role_id'] > 3)
	<a href="{{ route('backend.adjustment_partner', 'parent='.$adjustment['user_id']) }}">
		<p class="text-sm font-weight-bold mb-0">{{ $adjustment['name'] }}</p>
	</a>
	@else
	<p class="text-sm font-weight-normal mb-0">{{ $adjustment['name'] }}</p>
	@endif
	</td>
	<?php  
		$role = \VanguardLTE\Role::find($adjustment['role_id']);
	?>
	<td><p class="text-sm font-weight-normal mb-0">{{ $role->description }}</p></td>
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalin'],0) }}</p></td>
	<td><p class="text-danger text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalout'],0) }}</p></td>
	@if(auth()->user()->isInoutPartner())
		<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalin'] - $adjustment['totalout'],0) }}</p></td>
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['total_deal'] - $adjustment['total_mileage'],0) }}</p></td>
	@if ( auth()->user()->hasRole('admin') || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['total_ggr'] - $adjustment['total_ggr_mileage'] - ($adjustment['total_deal'] - $adjustment['total_mileage']),0) }}</p></td>
	@endif
	<td><p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($adjustment['dealout'],0) }}</p></td>
	{{--<td>{{ number_format($adjustment['moneyin'],0) }}</td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['moneyout'],0) }}</td</p>> --}}
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalbet'],0)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalwin'],0)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment['totalbet'] - $adjustment['totalwin'],0) }}</p></td>
	<!-- @if(auth()->user()->isInoutPartner())
	<td>{{ number_format($adjustment['ggr'],0) }}</td>
	<td>{{ number_format($adjustment['totalin'] - $adjustment['totalout'] - $adjustment['ggr'] ,0) }}</td>
	@endif -->
</tr>