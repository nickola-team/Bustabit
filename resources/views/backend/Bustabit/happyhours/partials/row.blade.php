<tr>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $happyhour->id }}</p>
	</td>
	<td>
		<a href="{{ route('backend.happyhour.edit', $happyhour->id) }}">
			<p class="ps-1 text-sm font-weight-bold mb-0">{{ $happyhour->user?$happyhour->user->username:'unknown' }}</p>
		</a>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($happyhour->total_bank,0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($happyhour->current_bank,0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($happyhour->over_bank,0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ ['비활성','메이저','그랜드'][$happyhour->jackpot] }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ \VanguardLTE\HappyHour::$values['time'][$happyhour->time] }}</p>
	</td>
	<td>
		@if($happyhour->status == 0)
			<span class="badge badge-sm bg-gradient-danger">차단</span>
		@elseif($happyhour->status == 1)
			<span class="badge badge-sm bg-gradient-success">활성</span>
		@else
			<span class="badge badge-sm bg-gradient-warning">완료</span>
		@endif
		
	</td>

</tr>