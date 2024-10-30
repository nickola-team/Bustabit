<tr>
    <td>
		@permission('games.edit')
		<a href="{{ route('backend.game.edit', $bank->game->id) }}">
			<p class="ps-1 text-sm font-weight-bold mb-0">{{ $bank->game->title }}</p>
		</a>
		@endpermission
	</td>
	<td>
		<p class="ps-1 text-sm font-weight-bold mb-0">{{ number_format($bank->slots,0) }}</p>
	</td>
	<td>
		<button type="button" class="btn bg-gradient-success btn-sm openAdd mb-0" data-bs-toggle="modal" data-bs-target="#openAddModal" data-type="slots" data-game="{{ $bank->game->id }}">
			환수금조절 
			<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
		</button>
	</td>
	<!-- <td>{{  number_format($bank->table_bank,0) }} 
		&nbsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-info btn-round btn-sm" data-toggle="modal" data-target="#openAddModal" data-type="table_bank"  data-game="{{ $bank->game->id }}">
			환수금조절
			<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
		</button>
	</td> -->
	<td>
		<p class="ps-1 text-sm font-weight-bold mb-0">{{  number_format($bank->bonus,0) }}</p>
	</td>
	<td>
		<button type="button" class="btn bg-gradient-success btn-sm openAdd mb-0" data-bs-toggle="modal" data-bs-target="#openAddModal" data-type="bonus"  data-game="{{ $bank->game->id }}">
			환수금조절
			<i class="material-icons">keyboard_arrow_right</i><div class="ripple-container"></div>
		</button>
	</td>
</tr>