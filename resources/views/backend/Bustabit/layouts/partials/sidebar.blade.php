<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main" data-color="success">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#">
        <img src="/assets/img/{{ auth()->user()->present()->role_id }}.png" class="navbar-brand-img h-100"/>

            <?php  
              $available_roles = Auth::user()->available_roles( true );
              $available_roles_trans = [];
              foreach ($available_roles as $key=>$role)
              {
                $role = \VanguardLTE\Role::find($key)->description;
                $available_roles_trans[$key] = $role;
              }
            ?>
        <span class="ms-2 ps-1 font-weight-bold text-white">{{ Auth::user()->username }} &nbsp; [{{$available_roles_trans[auth()->user()->role_id]}}]</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto ps " id="sidenav-collap\material-dashboard\pages\dashboardse-main">
      <ul class="navbar-nav">

        <!-- 대시보드 -->
        @permission('dashboard')
        @if (auth()->user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link text-white {{ Request::is('console') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.dashboard') }}">
              <i class="material-icons-round opacity-10">dashboard</i>
              <span class="nav-link-text ms-2 ps-1"> @lang('app.dashboard') </span>
            </a>
        </li>
        @endif
        @endpermission

        <!-- 회원구조 -->
        @permission('users.tree')
        @if (auth()->user()->hasRole(['admin','comaster', 'master','agent']))
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">파트너</h6>
        </li>

        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/tree*') ? 'active  bg-gradient-success' : ''  }}" href="{{ route('backend.user.tree') }}">
              <i class="material-icons-round">person_add</i>
              <span class="nav-link-text ms-2 ps-1"> 파트너 추가 </span>
            </a>
        </li>
        @endif
        @endpermission
        
        <!-- 파트너관리 -->
        @if ( auth()->check() && auth()->user()->hasRole(['admin','comaster', 'master','agent', 'distributor']) )
        <li class="nav-item">
            <a class="nav-link text-white {{ Request::is('console/shops*') || Request::is('console/partner*') || Request::is('console/user*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#partners">
                <i class="material-icons-round">people</i>
                <span class="nav-link-text ms-2 ps-1">파트너목록</span>
            </a>
            <div class="collapse {{ Request::is('console/shops*') || Request::is('console/partner*') || Request::is('console/user*') ? 'show' : '' }}" style="" id="partners">
                <ul class="nav">
                    <!-- 회원관리 -->
                    <li class="nav-item {{ Request::is('console/user*') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/user*') ? 'active' : ''  }}" href="{{ route('backend.user.list') }}">
                            <i class="material-icons-round">boy</i>
                            <span class="sidenav-normal  ms-2  ps-1"> {{\VanguardLTE\Role::where('slug','user')->first()->description}} </span>
                        </a>
                    </li>
                    <!-- 매장관리 -->
                    <li class="nav-item {{ Request::is('console/shops') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/shops') ? 'active' : ''  }}" href="{{ route('backend.shop.list') }}">
                            <i class="material-icons-round">man</i>
                            <span class="sidenav-normal  ms-2  ps-1"> 매장 </span>
                        </a>
                    </li>

                    @if ( auth()->check() && auth()->user()->hasRole(['admin','comaster', 'master','agent']) )
                    <li class="nav-item {{ Request::is('console/partner/4') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/partner/4') ? 'active' : ''  }}" href="{{ route('backend.user.partner', 4) }}">
                            <i class="material-icons-round">person</i>
                            <span class="sidenav-normal  ms-2  ps-1"> {{\VanguardLTE\Role::where('slug','distributor')->first()->description}} </span>
                        </a>
                    </li>
                    @endif
                    @if ( auth()->check() && auth()->user()->hasRole(['admin','comaster', 'master']) )
                    <li class="nav-item {{ Request::is('console/partner/5') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/partner/5') ? 'active' : ''  }}" href="{{ route('backend.user.partner', 5) }}">
                            <i class="material-icons-round">person_2</i>
                            <span class="sidenav-normal  ms-2  ps-1"> {{\VanguardLTE\Role::where('slug','agent')->first()->description}} </span>
                        </a>
                    </li>
                    @endif
                    @if ( auth()->check() && auth()->user()->hasRole(['admin','comaster']) )
                    <li class="nav-item {{ Request::is('console/partner/6') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/partner/6') ? 'active' : ''  }}" href="{{ route('backend.user.partner', 6) }}">
                            <i class="material-icons-round">person_3</i>
                            <span class="sidenav-normal  ms-2  ps-1"> {{\VanguardLTE\Role::where('slug','master')->first()->description}} </span>
                        </a>
                    </li>
                    @endif
                    @if ( auth()->check() && auth()->user()->hasRole(['admin']) )
                    <li class="nav-item {{ Request::is('console/partner/7') ? 'active' : ''  }}">
                        <a class="nav-link text-white {{ Request::is('console/partner/7') ? 'active' : ''  }}" href="{{ route('backend.user.partner', 7) }}">
                            <i class="material-icons-round">person_4</i>
                            <span class="sidenav-normal  ms-2  ps-1"> {{\VanguardLTE\Role::where('slug','comaster')->first()->description}} </span>
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">회원</h6>
        </li>

        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/user*') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.user.list') }}">
                <i class="material-icons-round">person</i>
                <span class="nav-link-text ms-2 ps-1"> 회원목록 </span>
            </a>
        </li>
        @endif
        
        @if ( auth()->user()->hasRole(['admin']) )
        <!-- <li class="nav-item">
          <hr class="horizontal light">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">게임</h6>
        </li> -->

        <!-- <li class="nav-item ">
            <a class="nav-link text-white {{ (Request::is('console/game') || Request::is('console/game/*')) ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.game.list') }}">
                <i class="material-icons-round">sports_esports</i>
                <span class="nav-link-text ms-2 ps-1"> 자체게임 </span>
            </a>
        </li> -->
        <!-- <li class="nav-item ">
            <a class="nav-link text-white {{ (Request::is('console/provider') || Request::is('console/provider/*')) ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.provider.list') }}">
                <i class="material-icons-round">sports_esports</i>
                <span class="nav-link-text ms-2 ps-1"> 기본게임 </span>
            </a>
        </li> -->
        <!-- <li class="nav-item ">
            <a class="nav-link text-white {{ (Request::is('console/gamebank') || Request::is('console/gamebank/*')) ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.game.bank') }}">
                <i class="material-icons-round">account_balance</i>
                <span class="nav-link-text ms-2 ps-1"> 환수금관리 </span>
            </a>
        </li> -->

        <!-- @permission('happyhours.manage')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/manipulates*') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.manipulate.list') }}">
                <i class="material-icons-round">card_giftcard</i>
                <span class="nav-link-text ms-2 ps-1"> 게임조작 </span>
            </a>
        </li>
        @endpermission -->
        @endif

        <li class="nav-item">
          <hr class="horizontal light">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">충환전</h6>
        </li>

        @if(auth()->user()->hasRole('admin'))
        @else
        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/in_out_request') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.in_out_request') }}">
                <i class="material-icons-round">request_page</i>
                <span class="nav-link-text ms-2 ps-1"> 충환전신청 </span>
            </a>
        </li>
        @endpermission
        @endif
        @if(auth()->user()->isInoutPartner() )
        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/in_out_manage/add') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.in_out_manage','add') }}">
                <i class="material-icons-round">add</i>
                <span class="nav-link-text ms-2 ps-1"> 충전신청관리 <sup id="in_newmark" style="background:green;color:white;font-size:12px;display: none;">&nbsp;N&nbsp;</sup></span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/in_out_manage/out') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.in_out_manage','out') }}">
                <i class="material-icons-round">remove</i>
                <span class="nav-link-text ms-2 ps-1"> 환전신청관리 <sup id="out_newmark" style="background:red;font-size:12px;color:white;display: none;">&nbsp;N&nbsp;</sup></span>
            </a>
        </li>
        @endpermission
        @endif

        <li class="nav-item">
          <hr class="horizontal light">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">정산</h6>
        </li>

        @if(auth()->user()->isInoutPartner() )
        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/adjustment_partner') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.adjustment_partner') }}">
                  <i class="material-icons-round">analytics</i>
                  <span class="nav-link-text ms-2 ps-1"> 파트너별정산 </span>
            </a>
        </li>
        @endpermission
        @endif

        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/adjustment_daily') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.adjustment_daily') }}"> 
                <i class="material-icons-round">equalizer</i>
                <span class="nav-link-text ms-2 ps-1"> 일일정산 </span>
            </a>
        </li>
        @endpermission

        @if(auth()->user()->hasRole('admin'))
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/adjustment_game') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.adjustment_game') }}">
                <i class="material-icons-round">trending_up</i>
                <span class="nav-link-text ms-2 ps-1"> 자체게임정산 </span>
            </a>
        </li>
        @endif
        
        <li class="nav-item">
          <hr class="horizontal light">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-6">내역</h6>
        </li>

        @permission('stats.game')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/stat_game') ? 'active bg-gradient-success' : ''  }}"  href="{{ route('backend.game_stat') }}">
                <i class="material-icons-round">data_usage</i>
                <span class="nav-link-text ms-2 ps-1"> 슬롯게임 </span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/stat_bet') ? 'active bg-gradient-success' : ''  }}"  href="{{ route('backend.bet_stat') }}">
                <i class="material-icons-round">data_usage</i>
                <span class="nav-link-text ms-2 ps-1"> 카지노게임 </span>
            </a>
        </li>
        @endpermission
        
        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/statistics*') ? 'active bg-gradient-success' : ''  }}"  href="{{ route('backend.statistics') }}">
                <i class="material-icons-round">paid</i>
                <span class="nav-link-text ms-2 ps-1"> 회원충환전 </span>
            </a>
        </li>
        @endpermission
        
        @permission('stats.shop')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/shop_stat') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.shop_stat') }}">
                <i class="material-icons-round">attach_money</i>
                <span class="nav-link-text ms-2 ps-1"> 매장충환전 </span>
            </a>
        </li>
        @endpermission

        @if(!auth()->user()->hasRole('manager'))
        @permission('stats.pay')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/partner_statistics*') ? 'active bg-gradient-success' : ''  }}"  href="{{ route('backend.statistics_partner') }}">
                <i class="material-icons-round">currency_exchange</i>
                <span class="nav-link-text ms-2 ps-1"> 파트너충환전 </span>
            </a>
        </li>
        @endpermission
        @endif

        @permission('stats.shop')
        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/deal_stat*') ? 'active bg-gradient-success' : ''  }}"  href="{{ route('backend.deal_stat') }}">
                <i class="material-icons-round">calculate</i>
                <span class="nav-link-text ms-2 ps-1"> 롤링 </span>
            </a>
        </li>
        @endpermission

        @if (auth()->user()->isInoutPartner())
        <li class="nav-item">
          <hr class="horizontal light">
        </li>

        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/notices*') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.notice.list') }}">
                <i class="material-icons-round">notifications</i>
                <span class="nav-link-text ms-2 ps-1"> 공지관리 </span>
            </a>
        </li>

        <li class="nav-item ">
            <a class="nav-link text-white {{ Request::is('console/activity*') ? 'active bg-gradient-success' : ''  }}" href="{{ route('backend.activity.index') }}">
                <i class="material-icons-round">history</i>
                <span class="nav-link-text ms-2 ps-1"> 접속로그 </span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('admin'))
        @else
        <li class="nav-item">
          <hr class="horizontal light">
        </li>

        <li class="nav-item ">
            <a class="nav-link text-white" target="_blank" href="https://t.me/foresight88">
                <i class="material-icons-round">person</i>
                <span class="nav-link-text ms-2 ps-1"> 문의하기 </span>
            </a>
        </li>
        @endif
      </ul>
    </div>
  </aside>