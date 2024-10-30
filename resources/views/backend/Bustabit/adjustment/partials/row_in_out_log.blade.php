<tr>
	@if($in_out_log->partner_type == 'partner')
	@if ($in_out_log->user)
	<?php  
		$role = \VanguardLTE\Role::find($in_out_log->user->role_id);
	?>
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $in_out_log->user->username }} [{{$role->description }}]</p>
	</td>
	@else
	<td>
		<p class="text-sm font-weight-normal mb-0">삭제된 파트너</p>
	</td>
	@endif
	@else
	@if ($in_out_log->shop)
	<td>
		<p class="text-sm font-weight-normal mb-0">{{ $in_out_log->shop->name }} [매장]
	</p></td>
	@else
	<td>
		<p class="text-sm font-weight-normal mb-0">삭제된 매장</p>
	</td>
	@endif
	@endif
	@if (auth()->user()->isInoutPartner())
	@if (auth()->user()->hasRole(['admin','comaster','master','agent']))
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($in_out_log->user && $in_out_log->user->role_id == 3)
	{{$in_out_log->user->referral->username}}
	@endif
	</p></td>
	@endif
	@if (auth()->user()->hasRole(['admin','comaster','master']))
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($in_out_log->user &&  $in_out_log->user->role_id == 3)
	{{$in_out_log->user->referral->referral->username}}
	@endif
	@if ($in_out_log->user &&  $in_out_log->user->role_id == 4)
	{{$in_out_log->user->referral->username}}
	@endif
	</p></td>
	@endif
	@if (auth()->user()->hasRole(['admin','comaster']))
	<td><p class="text-sm font-weight-normal mb-0">
	@if ($in_out_log->user &&  $in_out_log->user->role_id == 3)
	{{$in_out_log->user->referral->referral->referral->username}}
	@endif
	@if ($in_out_log->user &&  $in_out_log->user->role_id == 4)
	{{$in_out_log->user->referral->referral->username}}
	@endif
	@if ($in_out_log->user &&  $in_out_log->user->role_id == 5)
	{{$in_out_log->user->referral->username}}
	@endif
	</p></td>
	@endif
	@endif
	@if($in_out_log->type == 'add' )
	<td><p class="text-success text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p></td>
	@if (Request::is('console/in_out_history'))
	<td></td>
	@endif
	@elseif($in_out_log->type == 'out' )
	@if (Request::is('console/in_out_history'))
	<td></td>
	@endif
	<td><p class="text-warning text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p></td>
	@elseif($in_out_log->type == 'deal_out' )
	@if (Request::is('console/in_out_history'))
	<td></td>
	@endif
	<td><p class="text-danger text-sm font-weight-normal mb-0">{{ number_format($in_out_log->sum,0) }}</p></td>
	@endif
	@if ($in_out_log->partner_type == 'shop')
	@if (isset($in_out_log->shopStat))
	<td><p class="text-sm font-weight-normal mb-0">{{number_format($in_out_log->shopStat->old)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{number_format($in_out_log->shopStat->new)}}</p></td>
	@else
	<td></td><td></td>
	@endif
	@else
	@if (isset($in_out_log->transaction))
	<td><p class="text-sm font-weight-normal mb-0">{{number_format($in_out_log->transaction->old)}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{number_format($in_out_log->transaction->new)}}</p></td>
	@else
	<td></td><td></td>
	@endif
	@endif
	<td><p class="text-sm font-weight-normal mb-0">{{"[ " . $in_out_log->bank_name . " ] ". $in_out_log->account_no}}</p></td>

	<td><p class="text-sm font-weight-normal mb-0">{{ $in_out_log->recommender}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ $in_out_log->created_at}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ $in_out_log->updated_at}}</p></td>
	@if (Request::is('console/in_out_history'))
	<td>
		@if ($in_out_log->status==1)
		<span class="badge badge-sm bg-success">승인</span>
		@else
		<span class="badge badge-sm bg-danger">취소</span>
		@endif
	</td>
	@endif

</tr>