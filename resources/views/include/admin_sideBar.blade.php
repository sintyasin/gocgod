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

      <li class=" <?php if($active != 'productReport' && stripos($active, 'product') !== false) echo 'active'; ?> treeview">
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
          <li class=" <?php if($active == 'userReviewAgent') echo 'active'; ?> "><a href= {{ URL('admin/review/agent') }} ><i class="fa fa-circle-o"></i> Comment List</a></li>
          <li class=" <?php if($active == 'userReviewAgentRequest') echo 'active'; ?> "><a href= {{ URL('admin/review/agent/request') }} ><i class="fa fa-circle-o"></i> Comment Request</a></li>
          <li class=" <?php if($active == 'userAgentRequest') echo 'active'; ?> "><a href= {{ URL('admin/agent/request/list') }} ><i class="fa fa-circle-o"></i> Agent Request</a></li>
        </ul>
      </li>

      <li class="header">AGENT'S DEPOSIT AND FEE</li>

      <li class=" <?php if($active == 'deposit') echo 'active'; ?> ">
        <a href= {{URL('admin/deposit')}} >
          <i class="fa fa-money"></i> <span>Deposit Withdrawal</span>
        </a>
      </li>

      <li class=" <?php if($active == 'agentFee') echo 'active'; ?> ">
        <a href= {{URL('admin/agent/fee')}} >
          <i class="fa fa-paypal"></i> <span>Agent Fee</span>
        </a>
      </li>      

      <li class="header">ORDER DATA</li>

      <li class=" <?php if($active == 'txOrder') echo 'active'; ?> ">
        <a href= {{URL('admin/order')}} >
          <i class="fa fa-folder-o"></i> <span>Order Transaction</span>
        </a>
      </li>

      <li class=" <?php if($active == 'txOrderConfirm') echo 'active'; ?> ">
        <a href= {{URL('admin/order/confirm')}} >
          <i class="fa fa-sticky-note-o"></i> <span>Order Confirmation</span>
        </a>
      </li>

      <li class=" <?php if($active == 'purchase') echo 'active'; ?> ">
        <a href= {{URL('admin/purchase?dateStart=&dateEnd=&export=0')}} >
          <i class="fa fa-tasks"></i> <span>Purchase Order</span>
        </a>
      </li>

      <li class=" <?php if($active == 'productReport' || $active == 'txReport' || $active == 'agentReport') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-file-excel-o"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'txReport') echo 'active'; ?> "><a href={{ URL('/admin/report/tx?dateStart=&dateEnd=') }}><i class="fa fa-circle-o"></i> Transaction Report</a></li>
          <li class=" <?php if($active == 'productReport') echo 'active'; ?> "><a href={{ URL('/admin/report/product?dateStart=&dateEnd=') }} ><i class="fa fa-circle-o"></i> Product Report</a></li>
          <li class=" <?php if($active == 'agentReport') echo 'active'; ?> "><a href={{ URL('/admin/report/agent?dateStart=&dateEnd=') }} ><i class="fa fa-circle-o"></i> Agent Report</a></li>
        </ul>
      </li>

      <li class="header">MISCELLANEOUS</li>

      <li class=" <?php if($active == 'shippingScope') echo 'active'; ?> ">
        <a href= {{URL('admin/shipping/scope')}} >
          <i class="fa fa-globe"></i> <span>Scope of Shipping</span>
        </a>
      </li>

      <li class=" <?php if($active == 'bankList' || $active == 'insertBank') echo 'active'; ?> treeview">
        <a href="#">
          <i class="fa fa-bank"></i> <span>Bank</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class=" <?php if($active == 'bankList') echo 'active'; ?> "><a href={{ URL('/admin/bank/list') }}><i class="fa fa-circle-o"></i> Bank List</a></li>
          <li class=" <?php if($active == 'insertBank') echo 'active'; ?> "><a href={{ URL('/admin/insert/bank') }} ><i class="fa fa-circle-o"></i> Insert Bank</a></li>
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
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>