<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo/paminal.png" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo/Paminal_v7.png" alt="" height="60">
            </span>
        </a>
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo/paminal.png" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo/Paminal_v5.png" alt="" height="60">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a href="/" class="nav-link menu-link {{ Request::segment(1) == '' ? 'active' : '' }}"> <i class="bi bi-speedometer2"></i> <span data-key="t-dashboard">Dashboard</span> </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasus.index') }}" class="nav-link menu-link {{ Request::segment(1) == 'data-kasus' ? 'active' : '' }}"> <i class="bi bi-card-list"></i> <span data-key="t-dashboard">Data Pelanggar</span> </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasus.input') }}" class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                        <i class="bi bi-person-fill-add"></i> <span data-key="t-dashboard">Input Dumas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('list.anggota') }}"
                        class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i> <span data-key="t-dashboard">Anggota</span>
                    </a>
                </li>

                <li class="nav-item has-submenu">
                    <a class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-building-fill"></i> <span data-key="t-dashboard">Datasemen</span>
                    </a>
                    <ul class="submenu collapse" id="collapseExample">
                        <a href="{{ route('tambah.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                            <i class="bi bi-plus-square-fill"></i> <span data-key="t-dashboard">Tambah Datasemen</span>
                        </a>
                        <a href="{{ route('list.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i> <span data-key="t-dashboard">List Datasemen</span>
                        </a>
                        <a href="{{ route('unit.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                            <i class="bi bi-unity"></i> <span data-key="t-dashboard">Unit Datasemen</span>
                        </a>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link menu-link">
                        <i class="bi bi-box-arrow-right"></i> <span data-key="t-dashboard">Logout</span>
                    </a>
                </li>
                @can('manage-auth')
                <li class="menu-title"><span data-key="t-menu">Settings</span></li>
                <li class="nav-item">
                    <a href="/user" class="nav-link menu-link {{ Request::segment(1) == 'user' ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span data-key="t-dashboard">User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/role" class="nav-link menu-link {{ Request::segment(1) == 'role' ? 'active' : '' }}">
                        <i class="far fa-user-tag"></i> <span data-key="t-dashboard">Role</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>