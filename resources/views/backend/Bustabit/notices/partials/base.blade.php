<div class="row">
    @if (auth()->user()->hasRole('admin'))
    <div class="col-md-4">
        <div class="input-group input-group-static">
            <label>작성자</label>
            <input class="form-control" id="user" name="user" value="{{ ($edit && $notice->writer) ? $notice->writer->username : '' }}">
        </div>
    </div>
    @endif
    <div class="col-md-4">
        <div class="input-group input-group-static">
            <label>제목</label>
            <input class="form-control" id="title" name="title" required value="{{ $edit ? $notice->title : '' }}">
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-4">
        <div class="input-group input-group-static">
            <label>공지대상</label>
            {!! Form::select('type', \VanguardLTE\Notice::lists(), $edit ? $notice->type : 'user', ['id' => 'type', 'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="input-group input-group-static">
            <label>@lang('app.status')</label>
            {!! Form::select('active', ['0' => '비활성', '1' => '활성'], $edit ? $notice->active : 1, ['id' => 'active', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        <div class="input-group input-group-static">
            <textarea id="content" name="content" rows="20" cols="140">
                {{ $edit ? $notice->content : '공지내용을 입력하세요' }}
            </textarea>
        </div>
    </div>
</div>
