@extends('backend.White.layouts.app')

@section('page-title', '공지추가')
@section('page-heading', '공지추가')

@section('content')

    @include('backend.White.partials.messages')

    <div class="container-fluid py-4">
		<div class="row mt-4">
			<div class="col-md-6">
                {!! Form::open(['route' => 'backend.notice.store', 'id' => 'user-form']) !!}
        		<div class="card card-body">
                    @include('backend.White.notices.partials.base', ['edit' => false])
                    <div class="d-flex mt-4">
                        <button type="submit" class="btn bg-gradient-primary mb-0 ms-auto">추가</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- CK Editor -->
    <script src="/assets/node_modules/ckeditor/ckeditor.js"></script>
    <script>
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('content', {
            width: '100%',
        });
    })
    </script>
@endpush