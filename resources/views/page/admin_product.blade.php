@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Product
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Product</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <table id="example" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Weight</th>
            <th>Picture</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->


@push('scripts')
<script>
<?php 
  //counter buat increment $category pas mau ditampilin
  $count = 0; 
?>
$(function() {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('productlist.data') !!}',
        columns: [
            { data: 'varian_name', name: 'varian_name', title:'Name' },
            { data: 'price', name: 'price', title:'Price' },
            { data: 'qty', name: 'qty', title:'Quantity' },
            { data: 'weight', name: 'weight', title:'Weight' },
            { data: 'picture', name: 'picture', title:'Picture', render: function(data, type, row) {
              var x = "<img src={{ URL::asset('assets/images/product/') }}";
              x += "/" + "<?php echo $query[$count]->category->category_name . '/'; ?>" + data + " style='height:100px;' />";

              <?php 
                $count++;
              ?>
              return x;
            } },
            { data: 'description', name: 'description', title:'Description' },
            {data: 'actions', name: 'actions'}
        ]
    });
});
</script>
@endpush
@stop