<tr>
    <td>
		@permission('games.edit')
		<a href="{{ route('backend.game.edit', $game->id) }}">
			<p class="ps-1 text-sm font-weight-bold mb-0">{{ $game->title }}</p>
		</a>
		@endpermission
	</td>
	<!-- @permission('games.in_out')
	<td>{{ number_format($game->stat_in,0) }}</td>
	<td>{{ number_format($game->stat_out,0) }}</td>
	<td>
		@if(($game->stat_in - $game->stat_out) >= 0)
			<span class="text-green">
		@else
			<span class="text-red">
		@endif	
		{{ number_format($game->stat_in-$game->stat_out, 0) }}
		</span>
	</td>
	@endpermission
	<td>{{ number_format($game->bids) }}</td> -->
	<td>
		@if($game->view == 1)
			<span class="badge badge-sm bg-info">활성</span>
		@else
			<span class="badge badge-sm bg-secondary">비활성</span>
		@endif	
	</td>
	<td>
		@if($game->view == 1)
			<a href="{{route('backend.game.show', $game->id) . '?view=0'}}"
			class="btn bg-gradient-warning btn-sm mb-0"
			data-method="PUT"
			data-confirm-title="경고"
			data-confirm-text="{{ $game->title }} 게임을 비활성화 하시겠습니까?"
			data-confirm-delete="확인">
				비활성
			</a>
		@else
			<a href="{{ route('backend.game.show', $game->id) . '?view=1' }}"
				class="btn bg-gradient-success btn-sm mb-0"
				data-method="PUT"
				data-confirm-title="경고"
				data-confirm-text="{{ $game->title }} 게임을 활성화 하시겠습니까?"
				data-confirm-delete="확인">
					활성
				</a>
		@endif	
	</td>
</tr>