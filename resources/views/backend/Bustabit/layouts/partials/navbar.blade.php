<nav class="navbar navbar-main navbar-expand-lg mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
  <!-- position-sticky z-index-sticky -->
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <h4 class="font-weight-bolder mb-0">@yield('page-title')</h4>
    </nav>
    <div class="ps-4">
      <div class="form-check form-switch ps-0 mt-2 is-filled d-flex">
        <input class="form-check-input ms-auto" type="checkbox" id="smart-toggler">
        <label class="form-check-label text-body ms-3 text-truncate mb-0" for="smart-toggler">상세보기</label>
      </div>
    </div>
    <div class="ps-4">
      <div class="form-check form-switch ps-0 mt-2 is-filled d-flex">
        <input class="form-check-input ms-auto" type="checkbox" id="theme-toggler">
        <label class="form-check-label text-body ms-3 text-truncate mb-0" for="theme-toggler">다크 모드</label>
      </div>
    </div>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group input-group-outline">
        </div>
      </div>
      <ul class="navbar-nav  justify-content-end">
        @if(auth()->user()->hasRole('admin'))
        @else
        <li class="nav-item d-flex align-items-center pe-3">
            <div class="text-info font-weight-bolder" style="text-align: center;">보유금:
                @if( Auth::user()->hasRole(['cashier', 'manager']) )
                    @php
                        $shop = \VanguardLTE\Shop::find( auth()->user()->present()->shop_id );
                        echo $shop?number_format($shop->balance,0):0;
                    @endphp
                    원
                @else
                    {{ number_format(auth()->user()->present()->balance,0) }}원
                @endif
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            @if(auth()->user()->isInoutPartner())
            @else
            <div class="text-success font-weight-bolder" style="text-align: center;">수익금:
                @if( Auth::user()->hasRole(['cashier', 'manager']) )
                    @php
                        $shop = \VanguardLTE\Shop::find( auth()->user()->present()->shop_id );
                        echo $shop?number_format($shop->deal_balance,0):0;
                    @endphp
                    원
                @else
                    {{ number_format(auth()->user()->present()->deal_balance - auth()->user()->present()->mileage,0) }}
                    원
                @endif
            </div>
            @endif
        </li>
        @endif

        <li class="nav-item d-xl-none ps-3 pe-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>
        <li class="nav-item dropdown pe-2 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none mx-1">{{ auth()->user()->username }}</span>            
          </a>
          <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
            @if (config('session.driver') == 'database')
            <li class="dropdown-item mb-2">
              <div class="d-flex py-1">
                <a class="font-weight-bolder mb-0" href="{{ route('backend.profile.sessions') }}"> @lang('app.active_sessions')</a>
              </div>
            </li>
            @endif
            <li class="mb-2 dropdown-item">
              <div class="d-flex py-1">
                <a class="font-weight-bolder mb-0" href="{{ route('backend.user.edit', auth()->user()->present()->id) }}"> @lang('app.my_profile')</a>
              </div>
            </li>
            <li class="dropdown-item">
              <div class="d-flex py-1">
                <a class="font-weight-bolder mb-0" href="{{ route('backend.auth.logout') }}"> @lang('app.logout')</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>