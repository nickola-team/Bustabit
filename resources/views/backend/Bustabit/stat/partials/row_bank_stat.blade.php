<tr>
    <td>{{ $stat->name }}</td>
	{{-- <td>{{ $stat->user->username }}</td> --}}
	<td>{{ number_format($stat->old,0) }}</td>
	<td>{{ number_format($stat->new,0) }}</td>
	<td>
		@if ($stat->type == 'add')
		<span class="text-success">
			{{ number_format(abs($stat->sum),0) }}
		</span>
		@else
		<span></span>
		@endif
	</td>
	<td>
		@if ($stat->type != 'add')
		<span class="text-danger">
			{{ number_format(abs($stat->sum),0) }}
		</span>
		@else
		<span></span>
		@endif
	</td>
	<td>{{ $stat->created_at->format(config('app.date_time_format')) }}</td>
	@if(isset($show_shop) && $show_shop)
		@if($stat->shop)
			<td><a href="{{ route('backend.shop.edit', $stat->shop->id) }}">{{ $stat->shop->name }}</a></td>
		@endif
	@endif
</tr>