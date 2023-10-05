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
                    <a href="/" class="nav-link menu-link {{ Request::segment(1) == '' ? 'active' : '' }}"> <i class="far fa-tachometer-alt"></i> <span data-key="t-dashboard">Dashboard</span> </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasus.index') }}" class="nav-link menu-link {{ Request::segment(1) == 'data-kasus' ? 'active' : '' }}"> <i class="far fa-list-alt"></i> <span data-key="t-dashboard">Data Pelanggar</span> </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasus.input') }}" class="nav-link menu-link {{ Request::segment(1) == 'input-data-kasus' ? 'active' : '' }}">
                        <i class="far fa-user-plus"></i> <span data-key="t-dashboard">Input Data</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('list.anggota') }}"
                        class="nav-link menu-link {{ Request::segment(1) == 'list-anggota' ? 'active' : '' }}">
                        <i class="far fa-address-card"></i> <span data-key="t-dashboard">Anggota</span>
                    </a>
                </li>

                <li class="nav-item has-submenu">
                    <a class="nav-link menu-link {{ Request::segment(1) == 'tambah-datasemen' || Request::segment(1) == 'list-datasemen' || Request::segment(1) == 'unit-datasemen' ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="far fa-building"></i> <span data-key="t-dashboard">Bag / Detasemen</span>
                    </a>
                    <ul class="submenu collapse" id="collapseExample">
                        <a href="{{ route('tambah.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'tambah-datasemen' ? 'active' : '' }}">
                            <i class="far fa-plus-square"></i> <span data-key="t-dashboard">Tambah Bag / Detasemen</span>
                        </a>
                        <a href="{{ route('list.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'list-datasemen' ? 'active' : '' }}">
                            <i class="fas fa-list-ol"></i> <span data-key="t-dashboard">List Bag / Detasemen</span>
                        </a>
                        <a href="{{ route('unit.datasemen') }}" class="nav-link menu-link {{ Request::segment(1) == 'unit-datasemen' ? 'active' : '' }}">
                            <i class="far fa-users"></i> <span data-key="t-dashboard">Unit Bag / Detasemen</span>
                        </a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link menu-link" data-bs-toggle="modal" data-bs-target="#modal_import_yanduan">
                        <i class="far fa-file-import"></i> <span data-key="t-dashboard">Import Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link menu-link">
                        <i class="far fa-sign-out-alt"></i> <span data-key="t-dashboard">Logout</span>
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

<div class="modal fade" id="modal_import_yanduan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import data dari Yanduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="import_data">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Tanggal Mulai</label>
                  <input type="date" class="form-control" name="start">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Tanggal Terakhir</label>
                  <input type="date" class="form-control" name="end">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
