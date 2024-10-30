<tr>
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
		<p class="text-warning text-sm font-weight-normal mb-0">{{ number_format(abs($stat->summ),0) }}</p>
		@endif
	</td>

	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $stat->created_at->format(config('app.date_time_format')) }}</p>
	</td>
</tr>