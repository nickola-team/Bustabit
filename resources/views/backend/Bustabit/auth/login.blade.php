@extends('backend.White.layouts.auth')

@section('page-title', trans('app.login'))

@section('content')

<div class="page-header align-items-start min-vh-100" style="background-image: url('/assets/backend/White/img/Pink-mountain-wallpaper-HD.jpg');">
      <span class="mask bg-gradient-dark opacity-2"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-2">관리자페이지</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" action="<?= route('backend.auth.login.post') ?>" method="POST" id="login-form" autocomplete="off">
                  <input type="hidden" value="<?= csrf_token() ?>" name="_token">

                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">@lang('app.username')</label>
                    <input type="text" class="form-control" name="username" id="username">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">@lang('app.password')</label>
                    <input type="password" class="form-control" name="password" id="password">
                  </div>
                  <!-- <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div> -->
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" id="btn-login">@lang('app.log_in')</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

