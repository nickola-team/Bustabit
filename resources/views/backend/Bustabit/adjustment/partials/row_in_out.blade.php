<tr>
<td>
	<?php
		$hierarchy = '';
		if ($in_out_log->user){
			$level = $in_out_log->user->level();
			$parent = $in_out_log->user->referral;
			for (;$level<Auth::user()->level();$level++)
			{
				$role = \VanguardLTE\Role::find($parent->role_id);
				$hierarchy = $hierarchy . ' > ' . $parent->username .'[' .$role->description. ']';
				$parent = $parent->referral;
			}
		}
	?>
	@if($in_out_log->partner_type == 'partner')
		@if ($in_out_log->user)
		<a href="#" class="partnerInfo text-sm font-weight-bold mb-0" data-bs-toggle="modal" data-bs-target="#infoModal" data-id="{{ $hierarchy }}" >{{ $in_out_log->user->username }} [{{\VanguardLTE\Role::find($in_out_log->user->role_id)->description }}]</a>
		@else
		<p class="text-sm font-weight-normal mb-0">삭제된 파트너</p>
		@endif
	
	@else
		@if ($in_out_log->shop)
			<a href="#" class="partnerInfo text-sm font-weight-bold mb-0" data-bs-toggle="modal" data-bs-target="#infoModal" data-id="{{ $hierarchy }}" >{{ $in_out_log->shop->name }} [매장]</a>
		@else
			삭제된 매장
		@endif
	@endif
	
</td>
	@if($in_out_log->type == 'add' )
	<td>
		<p class="text-success text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p>
	</td>
	@elseif($in_out_log->type == 'out' )
	<td>
		<p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p>
	</td>
	@elseif($in_out_log->type == 'deal_out' )
	<td>
		<p class="text-danger text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p>
	</td>
	@endif
	<td>
		<p class="text-sm font-weight-normal mb-0">{{"[ " . $in_out_log->bank_name . " ] ". $in_out_log->account_no}}</p>
	</td>

	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $in_out_log->recommender}}</p>
	</td>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $in_out_log->created_at}}</p>
	</td>
	<td>
		@if($in_out_log->status == \VanguardLTE\WithdrawDeposit::WAIT)
		<span class="badge badge-sm bg-info">{{ \VanguardLTE\WithdrawDeposit::statMsg()[$in_out_log->status]}}</span>
		@elseif($in_out_log->status == \VanguardLTE\WithdrawDeposit::DONE)
		<span class="badge badge-sm bg-success">{{ \VanguardLTE\WithdrawDeposit::statMsg()[$in_out_log->status]}}</span>
		@elseif($in_out_log->status == \VanguardLTE\WithdrawDeposit::CANCEL)
		<span class="badge badge-sm bg-secondary">{{ \VanguardLTE\WithdrawDeposit::statMsg()[$in_out_log->status]}}</span>
		@else
		<span class="badge badge-sm bg-warning">{{ \VanguardLTE\WithdrawDeposit::statMsg()[$in_out_log->status]}}</span>
		@endif
	</td>

	@if($in_out_log->user_id != auth()->user()->id)
	<td>
		<button class="newPayment allowPayment btn bg-gradient-success btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openAllowModal" data-id="{{ $in_out_log->id }}">승인</button>
	@if($in_out_log->status == \VanguardLTE\WithdrawDeposit::REQUEST)
		<a href="{{ route('frontend.api.wait_in_out', $in_out_log->id) }}" >
			<button class="btn bg-gradient-warning btn-sm mb-0 text-xs">대기</button>
		</a>
	@endif
		<button class="newPayment rejectPayment btn bg-gradient-danger btn-sm mb-0 text-xs" data-bs-toggle="modal" data-bs-target="#openRejectModal" data-id="{{ $in_out_log->id }}">취소</button>
	</td>
	@endif
</tr>