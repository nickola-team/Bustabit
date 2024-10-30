<tr>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $idx + 1 }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-bold mb-0">{{ $manipulate->user ? $manipulate->user->username : '삭제된 회원' }}</p>
	</td>
	<td>
		@if ($manipulate->type == 'win')
		<p class="text-success text-sm font-weight-normal mb-0">당첨추가</p>
		@else
		<p class="text-warning text-sm font-weight-normal mb-0">당첨제한</p>
		@endif
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($manipulate->amount, 0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($manipulate->bet, 0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ number_format($manipulate->win, 0) }}</p>
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $manipulate->created_at }}</p>
	</td>
	@if($manipulate->status == 0)
	<td>
		<a href="{{ route('backend.manipulate.edit', $manipulate->id)}}" class="btn bg-gradient-warning btn-sm mb-0 text-xs">수정</a>
		<a href="{{ route('backend.manipulate.delete', $manipulate->id) }}"
			class="btn bg-gradient-primary btn-sm mb-0 text-xs"
			data-method="DELETE"
			data-confirm-title="경고"
			data-confirm-text="게임조작을 삭제하시겟습니까?"
			data-confirm-delete="확인">
				삭제
			</a>
	</td>
	@else
	<td>
		<p class="ps-1 text-sm font-weight-normal mb-0">{{ $manipulate->updated_at }}</p>
	</td>
	<td>
		@if ($manipulate->status == 1)
		<span class="badge badge-sm bg-gradient-info">완료됨</span>
		@elseif ($manipulate->status == 2)
		<span class="badge badge-sm bg-gradient-danger">삭제됨</span>
		@endif
	</td>
	@endif
</tr>