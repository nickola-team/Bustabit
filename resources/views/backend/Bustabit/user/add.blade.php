@extends('backend.White.layouts.app')
@if( Auth::user()->hasRole('cashier') || Auth::user()->hasRole('manager'))
@section('page-title', '회원 추가')
@section('page-heading', '회원 추가')
@else
@section('page-title', '파트너 추가')
@section('page-heading', '파트너 추가')
@endif

@section('content')
    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
        {!! Form::open(['route' => 'backend.user.store', 'files' => true, 'id' => 'user-form']) !!}
        <div class="card">
            <div class="card-body">
                @include('backend.White.user.partials.create')
            </div>
            <div class="card-footer d-flex pb-0">
                <button type="submit" class="btn bg-gradient-primary ms-auto">
                    추가
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@push('scripts')
    {!! JsValidator::formRequest('VanguardLTE\Http\Requests\User\CreateUserRequest', '#user-form') !!}

    <script>

        $("#role_id").change(function (event) {
            var role_id = parseInt($('#role_id').val());
            $("#parent > option").each(function() {
                var id = parseInt($(this).attr('role'));
                if( (id - role_id) != 1 ){
                    $(this).attr('hidden', true);
                } else{
                    $(this).attr('hidden', false);
                }
                $(this).attr('selected', false);
            });
            $('#parent option[value=""]').attr('selected', true);
        });

        $("#role_id").trigger('change');

    </script>
@endpush