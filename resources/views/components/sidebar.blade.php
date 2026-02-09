<nav class="pc-sidebar">
  <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{route('home')}}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid logo-lg" alt="logo" style="height: 3.5rem; width:10rem !important;">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{route('home')}}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('package.index')}}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-gift"></i></span>
                        <span class="pc-mtext">Packages</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('project.index')}}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-hierarchy-2"></i></span>
                        <span class="pc-mtext">Projects</span>
                    </a>
                </li>

                {{-- <li class="pc-item pc-caption">
                    <label>UI Components</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Menu
                        levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                            <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                            <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                            </ul>
                            </li>
                        </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                            <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                            <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                            </ul>
                            </li>
                        </ul>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
  </div>
</nav>