<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->

        @role('Super-Admin')
            <span class="brand-text font-weight-light">Brainlite Admin Dashboard</span>
        @endrole

        @role('admin')
            <span class="brand-text font-weight-light">Admin Dashboard - {{ auth()->user()->name }}</span>
        @endrole

        @role('writer')
            <span class="brand-text font-weight-light">Writer Dashboard - {{ auth()->user()->name }}</span>
        @endrole



    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column custom_admin_sidebar" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href=" {{ route('admin.dashboard') }}"
                        class="nav-link  @if (Request::is('admin/dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.students.index') }}"
                        class="nav-link  @if (Request::is('admin/students')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.users.index') }}"
                        class="nav-link  @if (Request::is('admin/users')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.daily-entries.index') }}"
                        class="nav-link  @if (Request::is('admin/daily-entries')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            daily Entries
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.batches.index') }}"
                        class="nav-link  @if (Request::is('admin/batches')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Batch
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.tc_ids.index') }}"
                        class="nav-link  @if (Request::is('admin/tc_ids')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            TC ID
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.job-roles.index') }}"
                        class="nav-link  @if (Request::is('admin/job-roles')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Job Role
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.sectors.index') }}"
                        class="nav-link  @if (Request::is('admin/sectors')) active @endif">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Sector
                        </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
