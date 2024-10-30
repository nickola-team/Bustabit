@extends('backend.White.layouts.app')

@section('page-title', '공지편집')
@section('page-heading', '공지편집')

@section('content')

    @include('backend.White.partials.messages')
  


    <div class="container-fluid py-4">
		<div class="row mt-4">
			<div class="col-md-6">
                {!! Form::open(['route' => array('backend.notice.update', $notice->id),  'id' => 'user-form']) !!}
        		<div class="card card-body">
                    @include('backend.White.notices.partials.base', ['edit' => true])
                    <div class="d-flex mt-4">
                        <button type="submit" class="btn bg-gradient-primary mb-0 ms-auto">수정</button>
                        <a href="{{ route('backend.notice.delete', $notice->id) }}"
                        class="btn bg-gradient-danger mb-0 mx-2"
                        data-method="DELETE"
                        data-confirm-title="@lang('app.please_confirm')"
                        data-confirm-text="공지를 삭제하시겠습니까?"
                        data-confirm-delete="@lang('app.yes_delete_him')">
                            삭제
                        </a>
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