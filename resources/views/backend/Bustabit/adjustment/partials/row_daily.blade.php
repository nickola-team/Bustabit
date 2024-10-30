<tr>
	@if($adjustment->user->hasRole('manager'))
	<td><p class="text-sm font-weight-normal mb-0">{{ $adjustment->user->username }}</p></td>
	@else
	<td><a href="{{ $type=='daily'?route('backend.adjustment_daily', ['parent'=>$adjustment->user_id]):route('backend.adjustment_monthly', ['parent'=>$adjustment->user_id]) }}">
		<p class="text-sm font-weight-bold mb-0">{{ $adjustment->user->username }}</p>
	</a></td>
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{ $type=='daily'?date('Y-m-d',strtotime($adjustment->date)):date('Y-m',strtotime($adjustment->date))}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment->totalin,0) }}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment->totalout,0) }}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment->totalbet,0)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment->totalwin,0)}}</p></td>
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($adjustment->total_deal-$adjustment->total_mileage,0)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($adjustment->dealout, 0) }}</p></td>
	@if ( auth()->user()->hasRole('admin') || auth()->user()->ggr_percent > 0 || (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($adjustment->total_ggr - $adjustment->total_ggr_mileage - ($adjustment->total_deal - $adjustment->total_mileage),0) }}</p></td>
	@else
	<td></td>
	@endif
</tr>