@extends('backend.White.layouts.app')

@section('page-title', trans('app.edit_shop'))
@section('page-heading', $shop->title)

@push('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
@endpush

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
        {!! Form::open(['route' => array('backend.shop.update', $shop->id), 'files' => true, 'id' => 'user-form']) !!}
        <div class="card">
            <div class="card-body">
                @include('backend.White.shops.partials.base', ['edit' => true])
            </div>
            <div class="card-footer d-flex pb-0">
                <button type="submit" class="btn bg-gradient-primary ms-auto">확인</button>
                @if(Auth::user()->isInoutPartner())
                <a href="{{ route('backend.shop.delete', $shop->id) }}"
                class="btn bg-gradient-danger mx-2"
                data-method="DELETE"
                data-confirm-title="@lang('app.please_confirm')"
                data-confirm-text="@lang('app.are_you_sure_delete_shop')"
                data-confirm-delete="@lang('app.yes_delete_him')">
                    @lang('app.delete_shop')
                </a>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<script>
    $( document ).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endpush