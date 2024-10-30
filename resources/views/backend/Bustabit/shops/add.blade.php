@extends('backend.White.layouts.app')

@section('page-title', trans('app.add_shop'))
@section('page-heading', trans('app.add_shop'))

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
        {!! Form::open(['route' => 'backend.shop.store', 'files' => true, 'id' => 'user-form']) !!}
        <div class="card">
            <div class="card-body pt-0">
                @include('backend.White.shops.partials.base', ['edit' => false, 'profile' => false])

                <h4>매장관리자</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>@lang('app.username')</label>
                            <input class="form-control" id="username" name="username" placeholder="이름을 입력하지 않으면 매장이름과 같은 관리자를 생성합니다.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static">
                            <label>{{ trans('app.password') }}</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex pt-0">
                <button type="submit" class="btn bg-gradient-primary ms-auto mt-3 mb-0">@lang('app.add_shop')</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection