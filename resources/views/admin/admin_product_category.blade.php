@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Product Category
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Product Category</li>
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
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Category</th>
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
var table;
function deleteCategory(name, id) 
{
  if (confirm("Are you sure want to delete: \n" + name + " ?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/delete/category') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw(false);
          alert('Data has been deleted');
        }
        else alert('Failed');
      }
    });
  } 
}

function editCategory(id) 
{
  window.location = "{{ URL::to('/admin/edit/category') }}" + "/" + id;
}

$(function() {
    table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('categorylist.data') !!}',
        columns: [
            { data: 'category_name', width:'25%', name: 'category_name', title:'Category' },
            { data: 'description', name: 'description', title:'Description' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "`" + row.category_name + "`";
              return '<a class="btn btn-warning" onclick="editCategory(' + row.category_id + ')" >' + 'Edit' + '</a> &nbsp;' +
                     '<a class="btn btn-danger" onclick="deleteCategory(' + data + "," + row.category_id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop