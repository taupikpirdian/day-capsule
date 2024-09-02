<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
      <div class="logo-wrapper"><a href="{{url('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar">
          <svg class="stroke-icon sidebar-toggle status_toggle middle">
            <use href="{{ asset('assets/svg/icon-sprite.svg#toggle-icon') }}"></use>
          </svg>
          <svg class="fill-icon sidebar-toggle status_toggle middle">
            <use href="{{asset('assets/svg/icon-sprite.svg#fill-toggle-icon')}}"></use>
          </svg>
        </div>
      </div>
      <div class="logo-icon-wrapper"><a href="{{url('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
      <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
          <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn"><a href="{{url('/dashboard')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
              <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>
            <li class="pin-title sidebar-main-title">
              <div> 
                <h6>Pinned</h6>
              </div>
            </li>
            @if (Auth::user()->hasRole('admin'))
              <li class="sidebar-main-title">
                <div>
                  <h6 class="lan-1">Master Data</h6>
                </div>
              </li>
              <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{url('permissions')}}">
                <svg class="stroke-icon">
                  <use href="{{asset('assets/svg/icon-sprite.svg#stroke-others')}}"></use>
                </svg>
                <span>Permission</span></a>
              </li>
              <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{url('roles')}}">
                  <svg class="stroke-icon">
                    <use href="{{asset('assets/svg/icon-sprite.svg#stroke-others')}}"></use>
                  </svg>
                  <span>Role</span></a>
              </li>
              <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{url('users')}}">
                  <svg class="stroke-icon">
                    <use href="{{asset('assets/svg/icon-sprite.svg#stroke-user')}}"></use>
                  </svg>
                  <span>User</span></a>
              </li>
            @endif
            @if(auth()->user()->hasAnyPermission([PERMISSION_LIST_ACTIVITY]))
              <li class="sidebar-main-title">
                <div>
                  <h6 class="lan-8">Applications</h6>
                </div>
              </li>
              @if(auth()->user()->can(PERMISSION_LIST_ACTIVITY))
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{url('activity')}}">
                    <svg class="stroke-icon">
                      <use href="{{asset('assets/svg/icon-sprite.svg#stroke-to-do')}}"></use>
                    </svg>
                    <span>Data Activity</span></a>
                </li>
              @endif
            @endif
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>
    </div>
  </div>