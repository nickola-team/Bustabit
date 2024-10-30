<div class="row">
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>회원아이디</label>
            <input type="text" class="form-control" name="username" value="{{$edit ? (\VanguardLTE\User::find($manipulate->user_id)->username ?? '삭제된 회원') : '' }}">
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>조작금액</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="0" value="{{ $edit ? $manipulate->amount : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>유형</label>
            {!! Form::select('type', ['win' => '당첨추가', 'lose' => '당첨제한'], $edit ? $manipulate->type : 'win', ['id' => 'type', 'class' => 'form-control', $edit ? 'disabled' : '']) !!}
        </div>
    </div>
</div>

@if ($edit)
<div class="row mt-2">
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>베팅금</label>
            <input type="number" class="form-control" id="bet" name="bet" value="{{ $manipulate->bet }}" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>당첨금</label>
            <input type="number" class="form-control" id="win" name="win" value="{{ $manipulate->win }}" disabled>
        </div>
    </div>
</div>
@endif