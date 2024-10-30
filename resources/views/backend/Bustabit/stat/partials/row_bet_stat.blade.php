<tr>
    <td>
		<p class="text-sm font-weight-normal mb-0">{{$stat->category->trans_kr}}</p>
	</td>
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($stat->user)
	{{ $stat->user->username }}
	@else
	삭제된 회원 - {{$stat->user_id}}
	@endif
	</p></td>
	<td>
		<p class="text-info text-sm font-weight-normal mb-0">{{ number_format($stat->balance,0) }}</p>
	</td>
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($stat->bet,0) }}</p></td>
	<td><p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($stat->win,0) }}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ date(config('app.date_time_format'), strtotime($stat->played_at)) }}</p></td>
    <!-- @if(isset($show_shop) && $show_shop)
        @if($stat->shop)
            <td><a href="{{ route('backend.shop.edit', $stat->shop->id) }}">{{ $stat->shop->name }}</a></td>
        @else
            <td>@lang('app.no_shop')</td>
        @endif
    @endif -->
</tr>