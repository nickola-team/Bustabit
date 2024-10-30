@extends('backend.White.layouts.app')

@section('page-title', '조작수정')
@section('page-heading', '조작수정')

@section('content')

  @include('backend.White.partials.messages')

  <div class="container-fluid py-4">
    {!! Form::open(['route' => array('backend.manipulate.update', $manipulate->id), 'id' => 'user-form']) !!}
    <div class="card mt-4">
      <div class="card-body">
        @include('backend.White.manipulate.partials.base', ['edit' => true])
      </div>
      <div class="card-footer d-flex">
        <button type="submit" class="btn bg-gradient-primary mb-0 ms-auto">적용</button>
      </div>
    {!! Form::close() !!}
  </div>
@endsection