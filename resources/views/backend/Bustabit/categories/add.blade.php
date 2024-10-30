@extends('backend.White.layouts.app')

@section('page-title', trans('app.add_category'))
@section('page-heading', trans('app.add_category'))

@section('content')

    <section class="content-header">
        @include('backend.White.partials.messages')
    </section>

    <section class="content">
        <div class="container-fluid">
        {!! Form::open(['route' => 'backend.category.store', 'files' => true, 'id' => 'user-form']) !!}
            <div class="card">
				<div class="card-header card-header-icon card-header-primary">
					<div class="card-icon">
						<i class="material-icons">assignment</i>
					</div>
					<h4 class="card-title ">@lang('app.add_category')</h4>
				</div>
				<div class="card-body">
                    <div class="row">
                        @include('backend.White.categories.partials.base', ['edit' => false, 'profile' => false])
                    </div>

                    <button type="submit" class="btn btn-primary">
                        @lang('app.add_category')
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

@stop