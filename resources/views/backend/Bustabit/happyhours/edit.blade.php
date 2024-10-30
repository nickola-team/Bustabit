@extends('backend.White.layouts.app')

@section('page-title', trans('app.edit_happyhour'))
@section('page-heading', $happyhour->title)

@section('content')

  @include('backend.White.partials.messages')

  <div class="container-fluid py-4">
    {!! Form::open(['route' => array('backend.happyhour.update', $happyhour->id), 'files' => true, 'id' => 'user-form']) !!}
    <div class="card mt-4">
      <div class="card-body">
        @include('backend.White.happyhours.partials.base', ['edit' => true])
      </div>
      <div class="card-footer d-flex">
        <button type="submit" class="btn bg-gradient-primary mb-0 ms-auto">수정</button>
        @permission('happyhours.delete')
            <a href="{{ route('backend.happyhour.delete', $happyhour->id) }}"
              class="btn bg-gradient-danger mb-0 mx-2"
              data-method="DELETE"
              data-confirm-title="@lang('app.please_confirm')"
              data-confirm-text="@lang('app.are_you_sure_delete_happyhour')"
              data-confirm-delete="@lang('app.yes_delete_him')">
                @lang('app.delete_happyhour')
            </a>
        @endpermission
      </div>
    {!! Form::close() !!}
  </div>
@endsection