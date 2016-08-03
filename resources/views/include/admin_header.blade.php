<header class="main-header">
<!-- Logo -->
<span class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <a style="color:white;" href={{URL('admin/product/list')}}><span class="logo-mini"><b>Go</b></span></a>
  <!-- logo for regular state and mobile devices -->
  <a style="color:white;" href={{URL('admin/order')}}><span class="logo-lg"><b>Admin</b>goCgoD</span></a>
</span>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="fa fa-user-md"></span>
          <span class="hidden-xs"> {{ auth('admin')->user()->name }} </span>
        </a>
        <ul class="dropdown-menu">
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href= {{ URL('admin/edit/profile') }} class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href={{ URL('/admin/logout') }} class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
</header>