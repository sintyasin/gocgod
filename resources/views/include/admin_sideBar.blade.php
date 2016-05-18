<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class=" <?php if(stripos($active, 'product') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-list"></i> <span>Product</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'productList') echo 'active'; ?> "><a href={{ URL('/adminproductlist/new') }}><i class="fa fa-circle-o"></i> Product List</a></li>
          <li class=" <?php if($active == 'insertProduct') echo 'active'; ?> "><a href= {{ URL('/admininsertproduct/new') }} ><i class="fa fa-circle-o"></i> Insert New Product</a></li>
          <li class=" <?php if($active == 'productCategory') echo 'active'; ?> "><a href= {{ URL('/admincategorylist/new') }} ><i class="fa fa-circle-o"></i> Category</a></li>
          <li class=" <?php if($active == 'productTestimonial') echo 'active'; ?> "><a href= {{ URL('/admintestimoniallist/new') }} ><i class="fa fa-circle-o"></i> Testimonial List</a></li>
          <li class=" <?php if($active == 'productTestimonialRequest') echo 'active'; ?> "><a href= {{ URL('/admintestimonialrequest/new') }} ><i class="fa fa-circle-o"></i> Testimonial Request</a></li>
          <li class=" <?php if($active == 'productSampleRequest') echo 'active'; ?> "><a href= {{ URL('/adminsamplerequest/new') }} ><i class="fa fa-circle-o"></i> Sample Request</a></li>
        </ul>
      </li>

      <li class=" <?php if(stripos($active, 'user') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'userMemberList') echo 'active'; ?> "><a href={{ URL('/admincustomerlist/new') }}><i class="fa fa-circle-o"></i> Customer List</a></li>
          <li class=" <?php if($active == 'userAgentList') echo 'active'; ?> "><a href= {{ URL('adminagentlist/new') }} ><i class="fa fa-circle-o"></i> Agent List</a></li>
          <li class=" <?php if($active == 'userReviewAgent') echo 'active'; ?> "><a href= {{ URL('adminreviewagent/new') }} ><i class="fa fa-circle-o"></i> Review Agent List</a></li>
          <li class=" <?php if($active == 'userReviewAgentRequest') echo 'active'; ?> "><a href= {{ URL('adminreviewagentrequest/new') }} ><i class="fa fa-circle-o"></i> Review Agent Request</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'faqList' || $active == 'insertFaq') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>FAQ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'faqList') echo 'active'; ?> "><a href={{ URL('/adminfaqlist/new') }}><i class="fa fa-circle-o"></i> Faq List</a></li>
          <li class=" <?php if($active == 'insertFaq') echo 'active'; ?> "><a href={{ URL('/admininsertfaq/new') }} ><i class="fa fa-circle-o"></i> Insert New</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'cityList' || $active == 'insertCity') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-globe"></i> <span>City</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'cityList') echo 'active'; ?> "><a href={{ URL('/admincitylist/new') }}><i class="fa fa-circle-o"></i> City List</a></li>
          <li class=" <?php if($active == 'insertCity') echo 'active'; ?> "><a href={{ URL('/admininsertcity/new') }} ><i class="fa fa-circle-o"></i> Insert City</a></li>
        </ul>
      </li>

      <li class=" <?php if($active == 'aboutus') echo 'active'; ?> ">
        <a href= {{URL('adminaboutus/new')}} >
          <i class="fa fa-file-text"></i> <span>About Us</span>
        </a>
      </li>

      <li class=" <?php if(stripos($active, 'banner') !== false) echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-photo"></i> <span>Banner</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'bannerList') echo 'active'; ?> "><a href={{ URL('/adminbanner/new') }}><i class="fa fa-circle-o"></i> Banner List</a></li>
          <li class=" <?php if($active == 'insertBanner') echo 'active'; ?> "><a href={{ URL('/admininsertbanner/new') }} ><i class="fa fa-circle-o"></i> Insert Banner</a></li>
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
      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>