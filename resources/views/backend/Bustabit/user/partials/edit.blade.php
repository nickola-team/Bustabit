<div class="card">
    <div class="card-body">
        <form action="" method="GET">
            <div class="input-group input-group-static my-3">
                <label>@lang('app.role')</label>
                <?php  
                    $available_roles = Auth::user()->available_roles( true );
                    $available_roles_trans = [];
                    foreach ($available_roles as $key=>$role)
                    {
                        $role = \VanguardLTE\Role::find($key)->description;
                        $available_roles_trans[$key] = $role;
                    }
                ?>

                {!! Form::select('role_id', $available_roles_trans, $edit ? $user->role_id : '',
                    ['class' => 'form-control selectpicker', 'id' => 'role_id', 'disabled' => true]) !!}
            </div>

            <div class="input-group input-group-static my-3">
                <label>@lang('app.shops')</label>
                {!! Form::select('shops[]', $shops, ($edit && $user->hasRole(['admin', 'agent', 'distributor'])) ? $user->shops(true) : Auth::user()->shop_id,
                    ['class' => 'form-control selectpicker', 'id' => 'shops', ($edit) ? 'disabled' : '', ($edit && $user->hasRole(['agent','distributor'])) ? 'multiple' : '']) !!}
            </div>
            @if(auth()->user()->hasRole('admin') && $user->hasRole('comaster'))
            <!-- <div class="input-group input-group-static my-3">
                <label>머니퍼센트</label>
                <input type="number" step="0.01" class="form-control" id="money_percent" name="money_percent" value="0">
            </div> -->
            @endif
            @if($user->hasRole(['master','agent','distributor']) || (auth()->user()->hasRole('admin') && $user->hasRole('comaster')))
                <div class="input-group input-group-static my-3">
                    <label>롤링%</label>
                    <input type="text" class="form-control" id="deal_percent" name="deal_percent" placeholder="(@lang('app.optional'))" value="{{ $edit ? $user->deal_percent : '' }}" {{$user->id == auth()->user()->id?'disabled':''}}>
                </div>
                <div class="input-group input-group-static my-3">
                    <label>라이브롤링%</label>
                    <input type="text" class="form-control" id="table_deal_percent" name="table_deal_percent" placeholder="(@lang('app.optional'))" value="{{ $edit ? $user->table_deal_percent : '' }}" {{$user->id == auth()->user()->id?'disabled':''}}>
                </div>
                <div class="input-group input-group-static my-3">
                    <label>벳윈%</label>
                    <input type="text" class="form-control" id="ggr_percent" name="ggr_percent" placeholder="(@lang('app.optional'))" value="{{ $edit ? $user->ggr_percent : '' }}" {{$user->id == auth()->user()->id?'disabled':''}}>
                </div>
                <div class="input-group input-group-static my-3">
                    <label>정산기간</label>
                    {!! Form::select('reset_days', \VanguardLTE\User::$values['reset_days'], $edit ? $user->reset_days : '' ,
                    ['class' => 'form-control', 'id' => 'reset_days', 'disabled' => ($user->hasRole(['master']) && $user->id != auth()->user()->id) ? false: true]) !!}
                </div>
            @endif

            <div class="input-group input-group-static my-3">
                <label>@lang('app.status')</label>
                {!! Form::select('status', $statuses, $edit ? $user->status : '' ,
                    ['class' => 'form-control', 'id' => 'status', 'disabled' => ($user->hasRole(['admin']) || $user->id == auth()->user()->id) ? true: false]) !!}
            </div>

            <div class="input-group input-group-static my-3">
                <label>@lang('app.username')</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="(@lang('app.optional'))" value="{{ $edit ? $user->username : '' }}">
            </div>

            @if( $user->email != '' )
            <div class="input-group input-group-static my-3">
                <label>@lang('app.email')</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="(@lang('app.optional'))" value="{{ $edit ? $user->email : '' }}">
            </div>
            @endif

            <div class="input-group input-group-static my-3">
                <label>{{ $edit ? trans("app.new_password") : trans('app.password') }}</label>
                <input type="password" class="form-control" id="password" name="password" @if ($edit) placeholder="@lang('app.leave_blank_if_you_dont_want_to_change')" @endif>
            </div>

            <div class="input-group input-group-static my-3">
                <label>{{ $edit ? trans("app.confirm_new_password") : trans('app.confirm_password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" @if ($edit) placeholder="@lang('app.leave_blank_if_you_dont_want_to_change')" @endif>
            </div>
        </form>
    </div>
    <div class="card-footer py-0 d-flex">
        @if( $user->id != Auth::id() )
        <div class="">
            @if(auth()->user()->isInoutPartner())
                @permission('users.delete')
                <a href="{{ route('backend.user.delete', $user->id) }}"
                    class="btn bg-gradient-warning"
                    data-method="DELETE"
                    data-confirm-title="회원 삭제"
                    data-confirm-text="{{ $user->username }} 회원을 삭제하시겠습니까?"
                    data-confirm-delete="확인">
                    <b>@lang('app.delete')</b></a>
                @endpermission
            @endif

            @if(auth()->user()->hasRole('admin') )
                <a href="{{ route('backend.user.hard_delete', $user->id) }}"
                    class="btn bg-gradient-danger"
                    data-method="DELETE"
                    data-confirm-title="어드민 삭제"
                    data-confirm-text="{{ $user->username }} 회원을 삭제하시겠습니까?"
                    data-confirm-delete="확인">
                    <b>어드민삭제</b></a>
            @endif
        </div>
        @endif

        <button type="submit" class="btn bg-gradient-primary ms-auto" id="update-details-btn">변경</button>
    </div>
</div>