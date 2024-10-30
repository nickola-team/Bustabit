<tr>
    <td>	
		<p class="text-sm font-weight-normal mb-0">{{$stat->category->trans_kr}}</p>
	</td>
	<td>	
		<p class="text-sm font-weight-normal mb-0">{{get_gamename($stat->category->game_code, $stat->game, $stat->type)}}</p>
	</td>
	<td>
	@if ($stat->user)
		<p class="text-sm font-weight-normal mb-0">{{ $stat->user->username }}</p>
	@else
		<p class="text-sm font-weight-normal mb-0">삭제된 회원 - {{$stat->user_id}}</p>
	@endif
	</td>
	@if($stat->type == 'shop')
	<td><p class="text-sm font-weight-normal mb-0">{{ $stat->shop->name }}</p></td>
	@else
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($stat->partner)
		{{ $stat->partner->username }}
	@else
		삭제된 파트너 - {{$stat->partner_id}}
	@endif
	</p></td>
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($stat->bet,2) }}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ number_format($stat->win,2) }}</p></td>
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($stat->deal_profit  - $stat->mileage,2) }}</p></td>
	@if (auth()->user()->hasRole('admin')  || (auth()->user()->hasRole(['master','agent', 'distributor']) && auth()->user()->ggr_percent > 0) 
		|| (auth()->user()->hasRole('manager') && auth()->user()->shop->ggr_percent > 0))
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($stat->ggr_profit  - $stat->ggr_mileage - ($stat->deal_profit  - $stat->mileage),2) }}</p></td>
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($stat->date_time)) }}</p></td>
    @if(isset($show_shop) && $show_shop)
        @if($stat->shop)
            <td><a href="{{ route('backend.shop.edit', $stat->shop->id) }}"><p class="text-sm font-weight-normal mb-0">{{ $stat->shop->name }}</p></a></td>
        @else
            <td>@lang('app.no_shop')</td>
        @endif
    @endif
</tr>