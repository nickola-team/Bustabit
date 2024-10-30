@extends('backend.White.layouts.app')

@section('page-title', trans('app.add_happyhour'))
@section('page-heading', trans('app.add_happyhour'))

@section('content')

  @include('backend.White.partials.messages')

  <div class="container-fluid py-4">
    {!! Form::open(['route' => 'backend.happyhour.store']) !!}
    <div class="card mt-4">
      <div class="card-body">
        @include('backend.White.happyhours.partials.base', ['edit' => false])
      </div>
      <div class="card-footer d-flex">
        <button type="submit" class="btn bg-gradient-primary mb-0 ms-auto">추가</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
@stop