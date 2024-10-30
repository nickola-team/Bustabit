@extends('backend.White.layouts.app')

@section('page-title', trans('app.edit_category'))
@section('page-heading', $category->title)

@section('content')

    <section class="content-header">
        @include('backend.White.partials.messages')
    </section>

    <section class="content">
        <div class="container-fluid">
            {!! Form::open(['route' => array('backend.category.update', $category->id), 'files' => true, 'id' => 'user-form']) !!}
            <div class="card">
				<div class="card-header card-header-icon card-header-primary">
					<div class="card-icon">
						<i class="material-icons">assignment</i>
					</div>
					<h4 class="card-title ">@lang('app.edit_category')</h4>
				</div>
				<div class="card-body">
                    <div class="row">
                        @include('backend.White.categories.partials.base', ['edit' => true])
                    </div>

                    <button type="submit" class="btn btn-primary">
                        @lang('app.edit_category')
                    </button>
                    @permission('categories.delete')
                    <a href="{{ route('backend.category.delete', $category->id) }}"
                    class="btn btn-danger"
                    data-method="DELETE"
                    data-confirm-title="@lang('app.please_confirm')"
                    data-confirm-text="@lang('app.are_you_sure_delete_category')"
                    data-confirm-delete="@lang('app.yes_delete_him')">
                        카테고리 삭제
                    </a>
                    @endpermission
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop

