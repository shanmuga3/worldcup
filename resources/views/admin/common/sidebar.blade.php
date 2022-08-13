<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
  <div class="brand-container">
    <a href="route('admin.dashboard')" class="brand-link">
      <img src="{{ $site_logo }}" alt="{{ $site_name }}" class="brand-image opacity-80 shadow">
      <span class="brand-text fw-light"> {{ $site_name }} </span>
    </a>
    <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fa-solid fa-angle-double-left"></i></a>
  </div>
  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <!-- Sidebar Menu -->
      <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ in_array($active_menu,['dashboard']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-tachometer-alt"></i>
            <p> Dashboard </p>
          </a>
        </li>
        @checkPermission('*-admin_users|*-roles|*-login_sliders')
        <li class="nav-item has-treeview {{ in_array($active_menu,['admin_users','roles']) ? 'menu-open active' : '' }}">
          <a href="#" class="nav-link {{ in_array($active_menu,['admin_users','roles']) ? 'active' : '' }}">
            <i class="nav-icon fa-solid fa-user-plus"></i>
            <p> Manage Admin </p>
            <i class="end fa-solid fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview {{ in_array($active_menu,['admin_users', 'roles','login_sliders']) ? 'menu-open':'' }}">
            @checkPermission('*-admin_users')
            <li class="nav-item">
              <a href="{{ route('admin.admin_users') }}" class="nav-link {{ in_array($active_menu,['admin_users']) ? 'active':'' }}">
                <i class="nav-icon far fa-circle"></i>
                <p> Admin Users </p>
              </a>
            </li>
            @endcheckPermission
            @checkPermission('*-roles')
            <li class="nav-item">
              <a href="{{ route('admin.roles') }}" class="nav-link {{ in_array($active_menu,['roles']) ? 'active':'' }}">
                <i class="nav-icon far fa-circle"></i>
                <p> Roles & Permissions </p>
              </a>
            </li>
            @endcheckPermission
          </ul>
        </li>
        @endcheckPermission
        @checkPermission('*-users')
        <li class="nav-item">
          <a href="{{ route('admin.users') }}" class="nav-link {{ in_array($active_menu,['users']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-users"></i>
            <p> Users </p>
          </a>
        </li>
        @endcheckPermission
        @checkPermission('*-users')
        <li class="nav-item">
          <a href="{{ route('admin.users.ranking') }}" class="nav-link {{ in_array($active_menu,['ranking']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-list"></i>
            <p> Ranking </p>
          </a>
        </li>
        @endcheckPermission
        @checkPermission('*-teams')
        <li class="nav-item">
          <a href="{{ route('admin.teams') }}" class="nav-link {{ in_array($active_menu,['teams']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-people-roof"></i>
            <p> Teams </p>
          </a>
        </li>
        @endcheckPermission
        @checkPermission('*-matches')
        <li class="nav-item">
          <a href="{{ route('admin.matches') }}" class="nav-link {{ in_array($active_menu,['matches']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-basketball"></i>
            <p> Matches </p>
          </a>
        </li>
        @endcheckPermission
        @checkPermission('*-guessess')
        <li class="nav-item">
          <a href="{{ route('admin.guessess') }}" class="nav-link {{ in_array($active_menu,['guessess']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-image"></i>
            <p> Guessess </p>
          </a>
        </li>
        @endcheckPermission
        @checkPermission('*-global_settings')
        <li class="nav-item">
          <a href="{{ route('admin.global_settings') }}" class="nav-link {{ in_array($active_menu,['global_settings']) ? 'active':'' }}">
            <i class="nav-icon fa-solid fa-gears"></i>
            <p> Global Settings </p>
          </a>
        </li>
        @endcheckPermission
      </ul>
    </nav>
  </div>
  <!-- /.sidebar -->
</aside>