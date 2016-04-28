<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <p style="color:white; padding-top:5px; padding-left:5px; margin-bottom:1px;">Alexander Pierce</p>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class=" <?php if($active == 'productList' || $active == 'insertProduct') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-list"></i> <span>Product</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'productList') echo 'active'; ?> "><a href={{ URL('/adminproductlist/') }}><i class="fa fa-circle-o"></i> Product List</a></li>
          <li class=" <?php if($active == 'insertProduct') echo 'active'; ?> "><a href=""><i class="fa fa-circle-o"></i> Insert New</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'memberList' || $active == 'agentList') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'memberList') echo 'active'; ?> "><a href={{ URL('/admincustomerlist/') }}><i class="fa fa-circle-o"></i> Customer List</a></li>
          <li class=" <?php if($active == 'agentList') echo 'active'; ?> "><a href= {{ URL('adminagentlist/') }} ><i class="fa fa-circle-o"></i> Agent List</a></li>
        </ul>
      </li>



      <li class=" ">
        <a href="">
          <i class="fa fa-user"></i> <span>Tes</span>
        </a>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href=""><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
          <li><a href=""><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
        </ul>
      </li>
      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>