@extends('backend.White.layouts.app')

@section('page-title', '잭팟편집')
@section('page-heading', $jackpot->title)

@section('content')

<section class="content-header">
@include('backend.White.partials.messages')
</section>

    <section class="content">
      <div class="container-fluid">
      {!! Form::open(['route' => array('backend.jpgame.update', $jackpot->id), 'files' => true, 'id' => 'user-form']) !!}

        <div class="card">
          <div class="card-header card-header-icon card-header-primary">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title ">잭팟편집</h4>
          </div>
          <div class="card-body">
            <div class="row">
              @include('backend.White.jpg.partials.base', ['edit' => true])
            </div>

            <button type="submit" class="btn btn-primary">
              편집
            </button>
          </div>
        </div>
  		{!! Form::close() !!}
      </div>
    </section>

@stop