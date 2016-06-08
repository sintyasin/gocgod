<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      
      @if(auth('admin')->user()->super == 1)
      <li class=" <?php if($active == 'adminList' || $active == 'addAdmin') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-user-plus"></i> <span>Admin</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'adminList') echo 'active'; ?> "><a href={{ URL('/admin/list') }}><i class="fa fa-circle-o"></i> Admin List</a></li>
          <li class=" <?php if($active == 'addAdmin') echo 'active'; ?> "><a href={{ URL('/admin/add') }} ><i class="fa fa-circle-o"></i> Add New Admin</a></li>
        </ul>
      </li>
      @endif

      <li class=" <?php if(stripos($active, 'product') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-list"></i> <span>Product</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'productList') echo 'active'; ?> "><a href={{ URL('/admin/product/list/') }}><i class="fa fa-circle-o"></i> Product List</a></li>
          <li class=" <?php if($active == 'insertProduct') echo 'active'; ?> "><a href= {{ URL('/admin/insert/product/') }} ><i class="fa fa-circle-o"></i> Insert New Product</a></li>
          <li class=" <?php if($active == 'productCategory') echo 'active'; ?> "><a href= {{ URL('/admin/category/list/') }} ><i class="fa fa-circle-o"></i> Category</a></li>
          <li class=" <?php if($active == 'productTestimonial') echo 'active'; ?> "><a href= {{ URL('/admin/testimonial/list') }} ><i class="fa fa-circle-o"></i> Testimonial List</a></li>
          <li class=" <?php if($active == 'productTestimonialRequest') echo 'active'; ?> "><a href= {{ URL('/admin/testimonial/request') }} ><i class="fa fa-circle-o"></i> Testimonial Request</a></li>
          <li class=" <?php if($active == 'productSampleRequest') echo 'active'; ?> "><a href= {{ URL('/admin/sample/request/') }} ><i class="fa fa-circle-o"></i> Sample Request</a></li>
        </ul>
      </li>

      <li class=" <?php if(stripos($active, 'user') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'userMemberList') echo 'active'; ?> "><a href={{ URL('/admin/customer/list') }}><i class="fa fa-circle-o"></i> Customer List</a></li>
          <li class=" <?php if($active == 'userAgentList') echo 'active'; ?> "><a href= {{ URL('admin/agent/list') }} ><i class="fa fa-circle-o"></i> Agent List</a></li>
          <li class=" <?php if($active == 'userReviewAgent') echo 'active'; ?> "><a href= {{ URL('admin/review/agent') }} ><i class="fa fa-circle-o"></i> Review Agent List</a></li>
          <li class=" <?php if($active == 'userReviewAgentRequest') echo 'active'; ?> "><a href= {{ URL('admin/review/agent/request') }} ><i class="fa fa-circle-o"></i> Review Agent Request</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'faqList' || $active == 'insertFaq') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-question"></i> <span>FAQ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'faqList') echo 'active'; ?> "><a href={{ URL('/admin/faq/list') }}><i class="fa fa-circle-o"></i> Faq List</a></li>
          <li class=" <?php if($active == 'insertFaq') echo 'active'; ?> "><a href={{ URL('/admin/insert/faq') }} ><i class="fa fa-circle-o"></i> Insert New</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'cityList' || $active == 'insertCity') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-globe"></i> <span>City</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'cityList') echo 'active'; ?> "><a href={{ URL('/admin/city/list') }}><i class="fa fa-circle-o"></i> City List</a></li>
          <li class=" <?php if($active == 'insertCity') echo 'active'; ?> "><a href={{ URL('/admin/insert/city') }} ><i class="fa fa-circle-o"></i> Insert City</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'txOrder' || $active == 'txShipping') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-folder-o"></i> <span>Transaction</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'txOrder') echo 'active'; ?> "><a href={{ URL('/admin/order') }}><i class="fa fa-circle-o"></i> Order Transaction</a></li>
          <li class=" <?php if($active == 'txShipping') echo 'active'; ?> "><a href={{ URL('/admin/ship') }} ><i class="fa fa-circle-o"></i> Shipping Transaction</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'cutOffDate') echo 'active'; ?> ">
        <a href= {{URL('admin/cut/off/date')}} >
          <i class="fa fa-calendar-plus-o"></i> <span>Cut Off Date</span>
        </a>
      </li>

      <li class=" <?php if($active == 'aboutus') echo 'active'; ?> ">
        <a href= {{URL('admin/aboutus')}} >
          <i class="fa fa-file-text"></i> <span>About Us</span>
        </a>
      </li>

      <li class=" <?php if(stripos($active, 'banner') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-photo"></i> <span>Banner</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'bannerList') echo 'active'; ?> "><a href={{ URL('/admin/banner/list') }}><i class="fa fa-circle-o"></i> Banner List</a></li>
          <li class=" <?php if($active == 'insertBanner') echo 'active'; ?> "><a href={{ URL('/admin/insert/banner') }} ><i class="fa fa-circle-o"></i> Insert Banner</a></li>
        </ul>
      </li>

      <li class=" ">
        <a href=>
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
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>