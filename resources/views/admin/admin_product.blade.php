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
    @if(Session::has('delete'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been deleted!</strong>
    </div>
    @elseif(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="producttable" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Category</th>
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

function deleteProduct(name, id) 
{
  if (confirm("Are you sure want to delete " + name + " ?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/delete/product') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(success)
      {
        if(success) location.reload();
        else alert('Failed');
      }
    });
    //window.location = "{{ URL::to('/admin/delete/product') }}" + "/" + id;
  } 
}

function editProduct(id) 
{
  window.location = "{{ URL::to('/admin/edit/product') }}" + "/" + id;
}

$(function() {
    var table = $('#producttable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('productlist.data') !!}',
        columns: [
            { data: 'varian_name', name: 'varian_name', title:'Name' },
            { data: 'category_name', name: 'category_name', title:'Category' },
            { data: 'price', name: 'price', title:'Price' },
            { data: 'qty', name: 'qty', title:'Quantity' },
            { data: 'weight', name: 'weight', title:'Weight' },
            { data: 'picture', name: 'picture', title:'Picture', render: function(data, type, row) {
              var x = "<img src={{ URL::asset('assets/images/product/') }}";
              x += "/" + row.category_name + "/" + data + " style='height:100px;' />";

              return x;
            } },
            { data: 'description', name: 'description', title:'Description' },
            {className: "dt-center", name: 'actions', render: function(data, type, row) {
              var data = "'" + row.varian_name + "'";
              return '<br> <a class="btn btn-warning" onclick="editProduct(' + row.varian_id + ')" >' + 'Edit' + '</a> <br><br>' +
                     '<a class="btn btn-danger" onclick="deleteProduct(' + data + ', ' + row.varian_id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop