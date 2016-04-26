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
    
    <table id="datatableProduct" class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

  </div><!-- /.row -->

</section><!-- /.content -->

@push('scripts')
<script>
$(function() {
    $('#datatableProduct').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('productlist.data') !!}',
        columns: [
            { data: 'varian_name', name: 'varian_name', title:'Name' },
        ]
    });
});
</script>
@endpush
@stop