<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/backend/White/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/assets/backend/White/img/favicon.png">
  <title>
    @yield('page-title')
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="/assets/backend/White/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/assets/backend/White/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="/assets/backend/White/css/material-dashboard.css?v=3.0.8" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-200" style="display:none">
    @include('backend.White.layouts.partials.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('backend.White.layouts.partials.navbar')

    @yield('content')

    @include('backend.White.layouts.partials.footer')
  </main>
  <div class="fixed-plugin" style="display:none">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php
      $user = auth()->user();
      $user_id = [];
      while ($user)
      {
          if ($user->isInoutPartner())
          {
              $user_id[] = $user->id;
          }
          $user = $user->referral;
      }
      $superadminId = \VanguardLTE\User::where('role_id',8)->first()->id;
      $notices = \VanguardLTE\Notice::where(['active' => 1])->whereIn('type', ['partner', 'all'])->whereIn('user_id',$user_id)->get(); //for admin's popup
  ?>
  @if (count($notices)>0)
      <div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-notice">
              <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">공지사항</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      @foreach ($notices as $id=>$notice)
                      <div class="instruction">
                          <p class="text-info font-weight-bold">{{ $notice->title }}</p>
                          <?php echo $notice->content  ?>
                          <br>
                      </div>
                      @endforeach
                  </div>
                  <div class="modal-footer justify-content-center">
                      <button type="button" class="btn bg-gradient-warning" data-bs-dismiss="modal" onclick="closeNotification(false);">30분동안 창을 열지 않음</button>
                      <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">닫기</button>
                  </div>
              </div>
          </div>
      </div>
  @endif

  <!--   Core JS Files   -->
  <script src="/assets/backend/White/js/core/popper.min.js"></script>
  <script src="/assets/backend/White/js/core/bootstrap.min.js"></script>
  <script src="/assets/backend/White/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/assets/backend/White/js/plugins/smooth-scrollbar.min.js"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets/backend/White/js/material-dashboard.min.js?v=3.0.4"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script src="/assets/js/delete.handler.js"></script>

  @stack('js')

  <script>
    $( document ).ready(function() {
        // dark mode
        if (localStorage.getItem('theme_toggle') === 'true') {
          darkMode(document.getElementById("theme-toggler"));
        }

        // detailed view
        if (localStorage.getItem('smart_toggle') === 'true') {
          document.getElementById("smart-toggler").setAttribute('checked', 'true');
        }
        else {
          const elements = document.querySelectorAll('[id=toggle-box]');

          elements.forEach(el => {
            el.style.display = 'none';
          });
        }

        let body = document.getElementsByTagName('body')[0];
        body.style.display = 'block';

        // initiate
        var updateTime = 2000;
        var apiUrl="/api/inoutlist.json";
        var timeout;
        var lastRequest = 0;
        var audio_in = new Audio("{{ url('/assets/sound/audio_in.mp3')}}");
        var audio_out = new Audio("{{ url('/assets/sound/audio_out.mp3')}}");
        $("#adj_newmark").hide();
        $("#in_newmark").hide();
        $("#out_newmark").hide();
        var updateInOutRequest = function (callback) {
            if (true) {
                $.ajax({
                    url: apiUrl,
                    type: "GET",
                    data: {'last':lastRequest, 'id': 
                        @if (Auth::check())
                            {{auth()->user()->id}} },
                        @else
                        0},
                        @endif
                    dataType: 'json',
                    success: function (data) {
                        var inouts=data;
                        lastRequest = inouts['now'];
                        if (inouts['add'] > 0)
                        {
                            if (inouts['rating'] > 0)
                            {
                                audio_in.play();
                            }
                            $("#adj_newmark").show();
                            $("#in_newmark").show();
                        }
                        if (inouts['out'] > 0)
                        {
                            if (inouts['rating'] > 0)
                            {
                                audio_out.play();
                            }
                            $("#adj_newmark").show();
                            $("#out_newmark").show();
                        }
                        if (inouts['add'] == 0 && inouts['out'] == 0)
                        {
                            $("#adj_newmark").hide();
                            $("#in_newmark").hide();
                            $("#out_newmark").hide();
                        }
                        timeout = setTimeout(updateInOutRequest, updateTime);
                        if (callback != null) callback();
                    },
                    error: function () {
                        timeout = setTimeout(updateInOutRequest, updateTime);
                        if (callback != null) callback();
                    }
                });
            } else {
                clearTimeout(timeout);
            }
        };

        timeout = setTimeout(updateInOutRequest, updateTime);

        if (document.getElementById('notification') != null) {
          var notifyModal = new bootstrap.Modal(document.getElementById('notification'), {
            keyboard: false
          })

          var prevTime = localStorage.getItem("hide_notification");
          if (prevTime && Date.now() - prevTime < 0.5 * 3600 * 1000) {
            notifyModal.hide();
          }
          else {
            notifyModal.show();
          }
        }

        $("#smart-toggler").click(function(event) {
          localStorage.setItem('smart_toggle', event.target.checked);

          if (event.target.checked) {
            $("[id=toggle-box]").fadeIn(500);
            event.target.setAttribute('checked', 'true');
          }
          else {
            $("[id=toggle-box]").fadeOut(500);
            event.target.removeAttribute('checked');
          }
        });

        $("#theme-toggler").click(function(event) {
          localStorage.setItem('theme_toggle', event.target.checked);

          darkMode(event.target);
        });
    });

    function closeNotification(onlyOnce) {
      if (onlyOnce) {
          
      }
      else {
          localStorage.setItem("hide_notification", Date.now());
      }
    }
  </script>
</body>

</html>